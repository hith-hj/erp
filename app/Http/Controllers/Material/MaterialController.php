<?php

namespace App\Http\Controllers\Material;

use App\DataTables\MaterialDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Material\MaterialRepository;
use App\Http\Validator\Material\MaterialValidator;
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
            'units' => $this->repo->getUnits(),
            'materials' => $this->repo->all(['id','name']),
        ]);
    }


    public function store(Request $request)
    {
        MaterialValidator::validateMaterialDetails($request);
        MaterialValidator::preventDublicateUnits($request);
        $material = $this->repo->add($request);        
        $this->repo->addUnits($request,$material);
        return redirect()->route('material.show',['id'=>$material->id]);
    }

    public function show($id)
    {
        return view('main.material.show', [
            'material' => $this->repo->findWith($id, ['inventories','units',]),
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
        return redirect()->route('material.all')->with('success','Deleted Successfuly');
    }
}
