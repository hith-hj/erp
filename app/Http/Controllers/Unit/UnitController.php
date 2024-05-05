<?php

namespace App\Http\Controllers\Unit;

use App\DataTables\UnitDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Unit\UnitRepository;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends BaseController
{
    private $repo;
    public function __construct()
    {
        $this->repo = new UnitRepository();
    }

    public function index()
    {
        return (new UnitDataTable())->render('main.unit.index');
    }

    public function show(Unit $unit)
    {
        return view('main.unit.show', ['unit' => $unit]);
    }

    public function create()
    {
        return view('main.unit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'units' => ['required', 'array', 'min:1'],
            'units.*.name' => ['required', 'unique:units,name'],
            'units.*.code' => ['required', 'unique:units,code'],
        ]);
        foreach ($request->units as $unit) {
            $this->repo->add($unit);
        }
        return redirect()->route('unit.all')->with('success', 'Unit Created');
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()->route('unit.all')->with('success', 'Unit Deleted');
    }
}
