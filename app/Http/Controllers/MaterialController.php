<?php

namespace App\Http\Controllers;

use App\DataTables\MaterialDataTable;
use App\Http\Repositories\MaterialRepository;
use App\Http\Validator\MaterialValidator;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends BaseController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new MaterialRepository;
    }

    public function index()
    {
        return (new MaterialDataTable)->render('main.material.index');
    }

    public function create()
    {
        return view('main.material.create', $this->repo->getCreatePayload());
    }

    public function store(Request $request)
    {
        MaterialValidator::validateMaterialDetails();
        MaterialValidator::preventDuplicateUnits($request);
        $material = $this->repo->add($request->only(['name', 'type', 'main_material']));
        $this->repo->addUnits($request, $material);

        return match ((int) $material->type) {
            1 => redirect()->route('material.show', ['id' => $material->id]),
            2 => redirect()->route('material.create_manufacture_model', ['id' => $material->id]),
            default => redirect()->route('material.show', ['id' => $material->id]),
        };
    }

    public function show($id)
    {
        return view('main.material.show', $this->repo->getShowPayload($id));
    }

    public function delete(Material $material)
    {
        $material->inventories()->detach();
        $material->units()->detach();
        $material->delete();

        return redirect()
            ->route('material.all')
            ->with('success', 'Deleted Successfuly');
    }

    public function createManufactureModel($id)
    {
        return view(
            'main.material.create_manufactured_material',
            $this->repo->getCreateManufactureModelPayload($id)
        );
    }

    public function storeMaterialManufactureModel(Request $request)
    {
        MaterialValidator::validateManufactureModel($request);
        $material = $this->repo->storeMaterialManufactureModel($request);

        return redirect()->route('material.show', ['id' => $material->id]);
    }

    public function statistics(Request $request)
    {
        return view('main.material.statistics', $this->repo->getStatisticsPayload());
    }

    public function getStatistics(Request $request)
    {
        MaterialValidator::validateMaterialStatistics($request);
        $material = $this->repo->find($request->input('material_id'));
        $result = $this->repo->getMaterialInventoriesStats($material, $request->get('inventories', []));

        return view('main.material.statistics', [
            'material_id' => $material->id,
            'result' => $result,
            ...$this->repo->getStatisticsPayload()
        ]);
    }
}
