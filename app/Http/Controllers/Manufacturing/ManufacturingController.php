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
            $manufuctering = $this->repo->storeManufacturig($request);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()
            ->route('manufacturing.show', ['manufuctering' => $manufuctering->id])
            ->with('success', 'manufacturing created');
    }
}
