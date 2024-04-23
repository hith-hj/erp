<?php

namespace App\Http\Controllers\Bill;

use App\DataTables\BillDataTable;
use App\DataTables\BillItemsDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Bill\BillRepository;
use App\Http\Repositories\Client\ClientRepository;
use App\Http\Repositories\Vendors\VendorRepository;
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
        $table = new BillItemsDataTable($bill);
        $data = $this->setDataArray($bill);
        return $table->render('main.bill.show',$data);
    }

    public function create()
    {
        return view('main.bill.create');
    }

    public function store(Request $request)
    {
        $bill = $this->repo->add($request);
        return redirect()->route('bill.show',['id'=>$bill->id])->with('success','Bill Created');
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()->route('bill.all')->with('success','Bill Deleted');
    }

    public function setDataArray($bill)
    {
        $fromToIndex = $bill->type ==1 ?'vendors':'clients';
        $fromToArray = $bill->type ==1 ? 
            (new VendorRepository())->all() : (new ClientRepository())->all();
        
        return [
            'bill'=>$bill,
            'inventories' => $this->repo->getInventories() ?? [],
            'currencies' => $this->repo->getCurrencies() ?? [],
            'materials' => $this->repo->getMaterials() ?? [],
            $fromToIndex => $fromToArray,
        ];
    }

    public function bill_store_purchase(Request $request,$id)
    {
        $this->repo->storePurchases($request);
        return redirect()
            ->route('bill.show',['id'=>$this->repo->find($id)])
            ->with('success','Stored Succefuly');
    }
   
    public function bill_delete_purchase($bill_id,$purchase_id)
    {
        $this->repo->deletePurchases($purchase_id);
        return redirect()
            ->route('bill.show',['id'=>$this->repo->find($bill_id)])
            ->with('success','Purchase Deleted');
    }

    public function bill_store_sale(Request $request,$id)
    {
        $this->repo->storeSale($request);
        return redirect()
            ->route('bill.show',['id'=>$this->repo->find($id)])
            ->with('success','Stored Succefuly');
    }

    public function bill_delete_sale($bill_id,$sale_id)
    {
        $this->repo->deleteSale($sale_id);
        return redirect()
            ->route('bill.show',['id'=>$this->repo->find($bill_id)])
            ->with('success','Deleted Succefuly');
    }

    public function save($bill_id)
    {
        try {
            $this->repo->save($bill_id);
        } catch (\Throwable $th) {
            return back()->with('error',$th->getMessage());
        }
        return redirect()
            ->route('bill.show',['id'=>$this->repo->find($bill_id)]);
    }
}
