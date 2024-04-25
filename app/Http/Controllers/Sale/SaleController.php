<?php

namespace App\Http\Controllers\Sale;

use App\DataTables\SaleDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Bill\BillRepository;
use App\Http\Repositories\Sale\SaleRepository;
use App\Http\Validator\Sale\SaleValidator;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends BaseController
{

    private $repo;

    public function __construct()
    {
        $this->repo = new SaleRepository(); 
    }

    public function index()
    {
        $table = new SaleDataTable();       
        return $table->render('main.sale.index');
    }

    public function show($id)
    {
        return view('main.sale.show',[
            'sale'=>$this->repo->findWith($id,['inventory','material','currency'])
        ]);
    }

    public function create()
    {
        return view('main.sale.create',[
            'inventories' => $this->repo->getInventories() ?? [],
            'currencies' => $this->repo->getCurrencies() ?? [],
            'materials' => $this->repo->getMaterials() ?? [],
            'clients' => $this->repo->getClients() ?? [] ,
            'bill' => (new BillRepository())->add(['type'=>2]),
        ]);   
    }

    public function store(Request $request)
    {
        SaleValidator::validate($request);
        foreach($request->sales as $sale)
        {
            $sale['bill_id'] = $request->bill_id;
            $sale['created_by'] = auth()->user()->id;
            try {
                $this->repo->updateInventoryMaterial($sale); 
                $sale = $this->repo->add($sale);
            } catch (\Throwable $th) {
                return back()->with('error',$th->getMessage());
            }       
        }
        return redirect()->route('bill.show',['id'=>$request->bill_id]);
    }

    public function delete(Sale $sale)
    {
        $this->repo->restorInventoryMaterial($sale->id);
        $this->repo->delete($sale->id);
        return redirect()->route('bill.show',['id'=>$sale->bill_id]);
    }
    
    public function storeToBill(Request $request)
    {
        SaleValidator::validate($request);
        try {
            $this->repo->updateInventoryMaterial($request);
            $sale = $this->repo->add($request);
        } catch (\Throwable $th) {
            return back()->with('error',$th->getMessage());
        }
    }

    public function deleteFromBill($sale_id)
    {
        $this->repo->restorInventoryMaterial($sale_id);
        return $this->repo->delete($sale_id);
    }
} 