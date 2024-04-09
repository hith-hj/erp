<?php

namespace App\Http\Controllers\Material;

use App\DataTables\MaterialDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Material\MaterialRepository;
use App\Http\Validator\Material\MaterialValidator;
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
        $this->setTrails();
        $table = new MaterialDataTable();       
        return $table->render('main.material.index');
    }


    public function create()
    {
        $this->setTrails();
        return view('main.material.create', [
            'units' => $this->repo->getUnits(),
        ]);
    }


    public function store(Request $request)
    {
        MaterialValidator::validateMaterialDetails($request);
        MaterialValidator::preventDublicateUnits($request);
        $material = $this->repo->add($request);        
        $material->units()
            ->attach($request->units);
        $material->units()
            ->attach($request->base_unit, ['is_default' => true]
            );
        return redirect()->route('material.show',['id'=>$material->id]);
    }

    public function show($id)
    {
        $this->setTrails();
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


    public function destroy($id)
    {
        //
    }
}
