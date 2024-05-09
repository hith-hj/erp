<?php

namespace App\Http\Controllers\Manufacturing;

use App\DataTables\ManufacturingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Manufacturing\ManufacturingRepository;
use Exception;
use Illuminate\Http\Request;

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
        return view('main.manufacturing.show',[
            'manufacturing'=>$this->repo->findWith($id,['bill','material','inventory',]),
        ]);
    }

    public function create()
    {
        return view('main.manufacturing.create',[
            'materials'=>$this->repo->getWithWhere(
                model: 'Material',
                where: [['type',2]],
                with: ['units:id,name,code']
            ) ?? [],
            'inventories'=>$this->repo->getWithWhere(
                model: 'Inventory',
                columns: ['id','name']
            ) ?? [],
        ]);
    }

    public function store(Request $request)
    {   
        try{
            $this->repo->storeManufacturig($request);
        }catch(Exception $th)
        {
            return redirect()->back()->with('error',$th->getMessage());
        }
        return redirect()
        ->route('manufacturing.all')
        ->with('success','manufacturing created');
    }
}
