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
            'materials'=>$this->repo->getMaterial(),
        ]);
    }

    public function create()
    {        
        return view('main.inventory.create', [
            'materials'=>$this->repo->getMaterial(),
        ]);
    }


    public function store(Request $request)
    {
        InventoryValidator::validateInventorylDetails($request);
        $inventory = $this->repo->add($request);
        foreach($request->materials as $key=>$value){
            $inventory->materials()->attach($key,['quantity'=>$value]);
        }
        return redirect()->route('inventory.show',['id'=>$inventory->id]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $inventory_id)
    {
        InventoryValidator::validateInventorylDetails($request);
        $inventory = $this->repo->find($inventory_id);
        foreach($request->materials as $key=>$value){
            $inventory->materials()->syncWithPivotValues($key,['quantity'=>$value]);
        }
        return redirect()->route('inventory.show',['id'=>$inventory->id]);
    }


    public function destroy($id)
    {
        //
    }

    public function material_store(Request $request,$inventory_id)
    {
        InventoryValidator::validateInventorylDetails($request);
        $inventory = $this->repo->find($inventory_id);
        foreach($request->materials as $key=>$value){
            if($inventory->materials()->where('material_id',$key)->exists())
            {
                $inventory->materials()
                ->syncWithPivotValues($key,[
                    'quantity'=>$value + $inventory->materials()
                    ->where('material_id',$key)->first()->pivot->quantity
                ],false);
            }else{
                $inventory->materials()->attach($key,['quantity'=>$value]);
            }
        }
        return redirect()->route('inventory.show',['id'=>$inventory->id]);
    }

    public function material_delete(Request $request,$inventory_id,$material_id)
    {
        $inventory = $this->repo->find($inventory_id);
        $material = $inventory->materials()->detach($material_id);
        return redirect()->route('inventory.show',['id'=>$inventory->id]);
    }
}
