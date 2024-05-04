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
            'inventories' => $this->repo->getWithWhere(
                model: 'Inventory',
                columns: ['id','name']
            ) ?? [],

            'currencies' => $this->repo->getWithWhere(
                model: 'Currency',
                with: ['rates:id,name'],
                columns: ['id', 'name', 'code']
            ) ?? [],

            'materials' => $this->repo->getWithWhere(
                model: 'Material',
                with: 'units',
                columns: ['id', 'name']
            ) ?? [],

            'vendors' => $this->repo->getWithWhere(
                model: 'Vendor',
                columns: ['id','first_name','last_name']
            ) ?? [] ,
            
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
        return redirect()
            ->route('bill.show',['id'=>$request->bill_id])
            ->with('success','Purchase created');
    }

    public function delete(Purchase $purchase)
    {
        $this->repo->restorInventoryMaterial($purchase->id);
        $this->repo->delete($purchase->id);
        return redirect()
        ->route('bill.show',['id'=>$purchase->bill_id])
        ->with('success','Purchase deleted');
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
