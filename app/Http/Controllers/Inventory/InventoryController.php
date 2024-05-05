<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\DataTables\InventoryDataTable;
use App\DataTables\InventoryMaterialDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Http\Validator\Inventory\InventoryValidator;
use App\Models\InventoryMaterial;
use App\Models\Material;
use App\Models\Unit;
use Yajra\DataTables\Facades\DataTables;

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
        $table = new InventoryMaterialDataTable($id);
        return $table->render('main.inventory.show', [
            'inventory' => $this->repo->findWith($id, ['materials']),
            'materials' => $this->repo->getWithWhere(model: 'material'),
        ]);
    }

    public function create()
    {
        return view('main.inventory.create', [
            'materials' => $this->repo->getWithWhere(model: 'material'),
        ]);
    }


    public function store(Request $request)
    {
        InventoryValidator::validateInventorylDetails($request);
        $inventory = $this->repo->add($request->only('name'));
        $materials = $this->repo->checkForMaterialDuplication($request->only('materials'));
        foreach ($materials as $materila) {
            $inventory->materials()->attach($materila['material_id'], ['quantity' => $materila['quantity']]);
        }
        return redirect()->route('inventory.show', ['id' => $inventory->id]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $inventory_id)
    {
        InventoryValidator::validateInventorylDetails($request);
        $inventory = $this->repo->find($inventory_id);
        foreach ($request->materials as $key => $value) {
            $inventory->materials()->syncWithPivotValues($key, ['quantity' => $value]);
        }
        return redirect()->route('inventory.show', ['id' => $inventory->id]);
    }

    public function material_store(Request $request, $inventory_id)
    {
        InventoryValidator::validateInventorylDetails($request);
        $inventory = $this->repo->find($inventory_id);
        $materials = $this->repo->checkForMaterialDuplication($request->only('materials'));
        $inventory = $this->repo->updateInventory($inventory, $materials);
        return redirect()->route('inventory.show', ['id' => $inventory->id]);
    }

    public function material_delete($inventory_id, $material_id)
    {
        $inventory = $this->repo->find($inventory_id);
        $inventory->materials()->detach($material_id);
        return redirect()->route('inventory.show', ['id' => $inventory->id]);
    }

    public function material_update(Request $request, $inventory_id, $material_id, $type = 'add')
    {
        $inventory = $this->repo->find($inventory_id);
        $material = $inventory->materials()->where('material_id', $material_id);
        $material->pivot->quantity = $type == 'add' ?
            $material->pivot->quantity + $request->quantity :
            $material->pivot->quantity - $request->quantity;
        return true;
    }
}
