<?php

namespace App\Http\Controllers\Manufacturing;

use App\DataTables\ManufacturingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Manufacturing\ManufacturingRepository;
use Illuminate\Http\Request;
use Exception;

class ManufacturingController extends Controller
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ManufacturingRepository();
    }

    public function index()
    {
        return (new ManufacturingDataTable())->render('main.manufacturing.index');
    }

    public function show($id)
    {
        return view('main.manufacturing.show', $this->repo->getShowPayload($id));
    }

    public function create()
    {
        return view('main.manufacturing.create', $this->repo->getCreatePayload());
    }

    public function store(Request $request)
    {
        try {
            $this->repo->storeManufacturig($request);
        } catch (Exception $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        return redirect()
            ->route('manufacturing.all')
            ->with('success', 'manufacturing created');
    }

    public function billShow($id)
    {
        return view(
            view: 'main.manufacturing.show',
            data: [
                'manufacturing' => $this->repo->getter(
                    model: 'manufacturing',
                    callable: [
                        'where' => ['bill_id' => $id],
                        'with' => ['bill', 'material', 'inventory',]
                    ],
                    getter: 'first'
                ),
            ]
        );
    }
}
