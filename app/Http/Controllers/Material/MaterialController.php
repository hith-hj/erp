<?php

namespace App\Http\Controllers\Material;

use App\DataTables\MaterialDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Material\MaterialRepository;
use App\Http\Validator\Material\MaterialValidator;
use App\Models\Account;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends BaseController
{
    private $repo;
    private $userValidator;

    public function __construct()
    {
        $this->repo = new MaterialRepository();
    }


    public function index()
    {
        $table = new MaterialDataTable();
        return $table->render('main.material.index');
    }


    public function create()
    {
        return view('main.material.create', [
            'units' => $this->repo->getWithWhere('unit',column:['id','name','code']),
            'materials' => $this->repo->all(['id', 'name']),
        ]);
    }


    public function store(Request $request)
    {
        MaterialValidator::validateMaterialDetails();
        MaterialValidator::preventDuplicateUnits($request);
        $material = $this->repo->add($request->only(['name', 'type', 'main_material']));
        $this->repo->addUnits($request, $material);
        return match ((int)$material->type) {
            1 => redirect()->route('material.show', ['id' => $material->id]),
            2 => redirect()->route('material.create_manufactured_material', ['id' => $material->id]),
            default => redirect()->route('material.show', ['id' => $material->id]),
        };
    }

    public function show($id)
    {
        return view('main.material.show', [
            'material' => $this->repo->findWith($id, ['inventories', 'units',]),
        ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function delete(Material $material)
    {
        $material->inventories()->detach();
        $material->units()->detach();
        $material->delete();
        return redirect()->route('material.all')->with('success', 'Deleted Successfuly');
    }

    public function createManufacturedMaterial($id)
    {
        return view('main.material.create_manufactured_material', [
            'material' => $this->repo->find($id),
            'materials' => $this->repo->getWithWhere(
                model:'Material',
                with: ['units', 'inventories'],
                where: [['type', 1]]
            ),
            'currencies' => $this->repo->getWithWhere(
                model:'Currency',
                column: ['id', 'name']
            ),
            'inventories' => $this->repo->getWithWhere(
                model:'Inventory',
                column: ['id', 'name']
            ),
            'expenses' => $this->repo->getWithWhere(
                model:'Expense',
                column: ['id', 'name']
            ),
            'accountTypes' => $this->repo->getWithWhere(
                model: 'accountType',
                column: ['id','name'],
            ),
        ]);
    }

    public function storeMaterialManufactureModel(Request $request)
    {
        MaterialValidator::validateManufactureModel($request);
        $material = $this->repo->find($request->material_id);
        foreach ($request->materials as $item) {
            $material->manufactureModel()->create($item);
        }
        $account = Account::create([
            'type' => $request->account_id,
            'accountable_id' => $material->id,
            'accountable_type' => get_class($material),
        ]);
        foreach ($request->expenses as $expense) {
            $expense = (object)$expense;
            $account->expenses()->attach($expense->expense_id, [
                'cost' => $expense->cost,
                'note' => $expense->note,
            ]);
        }

        return redirect()->route('material.show', ['id' => $material->id]);
    }
}
