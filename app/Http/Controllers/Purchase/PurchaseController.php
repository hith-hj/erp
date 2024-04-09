<?php

namespace App\Http\Controllers\Purchase;

use App\DataTables\PurchaseDataTable;
use App\Http\Controllers\BaseController;
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
        $this->setTrails();
        $table = new PurchaseDataTable();       
        return $table->render('main.purchase.index');
    }

    public function show($id)
    {
        $this->setTrails();
        return view('main.purchase.show',[
            'purchase'=>$this->repo->findWith($id,['inventory','material','currency'])
        ]);
    }

    public function create()
    {
        $this->setTrails();
        return view('main.purchase.create',[
            'inventories' => $this->repo->getInventories() ?? [],
            'currencies' => $this->repo->getCurrencies() ?? [],
            'materials' => $this->repo->getMaterials() ?? [],
            'accounts' => [
                ['id'=>1,'name'=>'acc_1'],
                ['id'=>2,'name'=>'acc_2'],
                ['id'=>3,'name'=>'acc_3']
            ],
            'vendors' => [
                ['id'=>1,'name'=>'vend_1'],
                ['id'=>2,'name'=>'vend_2'],
                ['id'=>3,'name'=>'vend_3']
            ],
        ]);   
    }

    public function store(Request $request)
    {
        PurchaseValidator::validate($request);
        $purchase = $this->repo->add($request);
        $this->repo->updateInventoryMaterial($request);        
        return redirect()->route('purchase.show',['id'=>$purchase->id]);
    }

    public function storeTobill(Request $request)
    {
        PurchaseValidator::validate($request);
        $purchase = $this->repo->add($request);
        return $this->repo->updateInventoryMaterial($request);
    }

    public function deleteFrombill($purchase_id)
    {
        $this->repo->restorInventoryMaterial($purchase_id);
        return $this->repo->delete($purchase_id);
    }
}         
