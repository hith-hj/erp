<?php

namespace App\Http\Controllers\Purchase;

use App\DataTables\PurchaseDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Bill\BillRepository;
use App\Http\Repositories\Purchase\PurchaseRepository;
use App\Http\Validator\Purchase\PurchaseValidator;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends BaseController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new PurchaseRepository();
    }

    public function index()
    {
        $table = new PurchaseDataTable();       
        return $table->render('main.purchase.index');
    }

    public function show($id)
    {
        return view('main.purchase.show',[
            'purchase'=>$this->repo->findWith($id,['inventory','material','currency'])
        ]);
    }

    public function create()
    {
        return view('main.purchase.create',[
            'inventories' => $this->repo->getInventories() ?? [],
            'currencies' => $this->repo->getCurrencies() ?? [],
            'materials' => $this->repo->getMaterials() ?? [],
            'vendors' => $this->repo->getVendors() ?? [] ,
            'bill' => (new BillRepository())->add(['type'=>1]),
        ]);   
    }

    public function store(Request $request)
    {
        PurchaseValidator::validate($request);
        foreach($request->purchases as $purchase)
        {
            $purchase['bill_id'] = $request->bill_id;
            $purchase['created_by'] = auth()->user()->id;
            $purchase = $this->repo->add($purchase);
            $this->repo->updateInventoryMaterial($purchase);        
        }
        return redirect()->route('bill.show',['id'=>$request->bill_id]);
    }

    public function delete(Purchase $purchase)
    {
        $this->repo->restorInventoryMaterial($purchase->id);
        $this->repo->delete($purchase->id);
        return redirect()->route('bill.show',['id'=>$purchase->bill_id]);
    }

    public function storeToBill(Request $request)
    {
        PurchaseValidator::validate($request);
        $purchase = $this->repo->add($request);
        return $this->repo->updateInventoryMaterial($request);
    }

    public function deleteFromBill($purchase_id)
    {
        $this->repo->restorInventoryMaterial($purchase_id);
        return $this->repo->delete($purchase_id);
    }
}         
