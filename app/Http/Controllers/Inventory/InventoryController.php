<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\DataTables\InventoryDataTable;
use App\DataTables\InventoryMaterialDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Http\Validator\Inventory\InventoryValidator;

class InventoryController extends BaseController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new InventoryRepository();
    }

    public function index()
    {
        $table = new InventoryDataTable();
        return $table->render('main.inventory.index');
    }

    public function show($id)
    {
        return (new InventoryMaterialDataTable($id))
            ->render('main.inventory.show', $this->repo->getShowPayload($id));
    }

    public function create()
    {
        return view('main.inventory.create', $this->repo->getCreatePayload());
    }

    public function store(Request $request)
    {
        InventoryValidator::validateInventorylDetails($request);
        $inventory = $this->repo->add($request->only('name'));
        if ($request->is_default && $this->defaultDontExist()) {
            $this->repo->setDefault($inventory->id);
        }
        $materials = $this->repo->checkForMaterialDuplication($request->only('materials'));

        foreach ($materials as $materila) {
            $inventory
                ->materials()
                ->attach($materila['material_id'], ['quantity' => $materila['quantity']]);
        }

        return redirect()->route('inventory.show', ['id' => $inventory->id]);
    }

    public function update(Request $request, $inventory_id)
    {
        InventoryValidator::validateInventorylDetails($request);

        $inventory = $this->repo->find($inventory_id);

        foreach ($request->materials as $key => $value) {
            $inventory
                ->materials()
                ->syncWithPivotValues($key, ['quantity' => $value]);
        }

        return redirect()->route('inventory.show', ['id' => $inventory->id]);
    }

    public function setDefault($id)
    {
        $this->repo->setDefault($id);
        return redirect()
            ->route('inventory.show', ['id' => $id])
            ->with('success', 'inventory updated');
    }

    public function material_store(Request $request, $inventory_id)
    {
        InventoryValidator::validateInventorylDetails($request);

        $inventory = $this->repo->find($inventory_id);
        
        $materials = $this->repo->checkForMaterialDuplication($request->only('materials'));
        
        $inventory = $this->repo->updateInventory($inventory, $materials);
        
        return redirect()
        ->route('inventory.show', ['id' => $inventory->id])
        ->with('success', 'Material added to inventory ');
    }
    
    public function material_delete($inventory_id, $material_id)
    {
        $inventory = $this->repo->find($inventory_id);
        $inventory->materials()->detach($material_id);
        return redirect()->route('inventory.show', ['id' => $inventory->id])
        ->with('success', 'Material removed from inventory ');
    }

    public function material_update(
        Request $request,
        $inventory_id,
        $material_id,
        $type = 'add'
    ) {
        $inventory = $this->repo->find($inventory_id);
        $material = $inventory->materials()->where('material_id', $material_id);
        $material->pivot->quantity = $type == 'add' ?
            $material->pivot->quantity + $request->quantity :
            $material->pivot->quantity - $request->quantity;
        return true;
    }
}
