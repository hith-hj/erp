<?php

namespace App\Http\Controllers\Bill;

use App\DataTables\BillDataTable;
use App\DataTables\BillItemsDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Bill\BillRepository;
use Illuminate\Http\Request;

class BillController extends BaseController
{
    private $repo ;

    public function __construct()
    {
        $this->repo = new BillRepository();
    }

    public function index()
    {
        $table = new BillDataTable();
        return $table->render('main.bill.index');
    }

    public function show($id)
    {
        $bill = $this->repo->findWith($id,['items']);
        $table = new BillItemsDataTable($bill->type,$bill->id);
        return $table->render('main.bill.show',[
            'bill'=>$bill,
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
            'titles'=>[$bill->serial],
        ]);
    }

    public function create()
    {
        return view('main.bill.create');
    }

    public function store(Request $request)
    {
        $bill = $this->repo->add($request);
        return redirect()->route('bill.show',['id'=>$bill->id]);
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()->route('bill.all');
    }

    public function bill_store_purchases(Request $request,$id)
    {
        $this->repo->storePurchases($request);
        return redirect()->route('bill.show',['id'=>$this->repo->find($id)])
            ->with('success','Stored Succefuly');
    }
   
    public function bill_delete_purchases($bill_id,$purchase_id)
    {
        $this->repo->deletePurchases($purchase_id);
        return redirect()->route('bill.show',['id'=>$this->repo->find($bill_id)]);
    }

    public function save($bill_id)
    {
        try {
            $this->repo->save($bill_id);
        } catch (\Throwable $th) {
            return back()->with('error',$th->getMessage());
        }
        return redirect()->route('bill.show',['id'=>$this->repo->find($bill_id)]);
    }
}
