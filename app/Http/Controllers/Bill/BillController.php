<?php

namespace App\Http\Controllers\Bill;

use App\DataTables\BillDataTable;
use App\DataTables\BillItemsDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Bill\BillRepository;
use App\Http\Repositories\Client\ClientRepository;
use App\Http\Repositories\Vendors\VendorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $bill = $this->repo->findWith($id,relation:['items']);
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
        $bill = $this->repo->add($request->only('type'));
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
        $fromToArray = $this->repo->getWithWhere(
            model: Str::singular($fromToIndex),
            columns:['id','first_name','last_name'],
        );
        
        return [
            'bill'=>$bill,
            'inventories' => $this->repo->getWithWhere(
                model: 'Inventory',
                columns: ['id','name',]
                ) ?? [],
            'currencies' => $this->repo->getWithWhere(
                model: 'currency',
                with: ['rates:id,name'],
                columns:['id','name','code']
            ) ?? [],
            'materials' => $this->repo->getWithWhere(
                model: 'material',
                with: ['units','inventories'],
                columns: ['id','name']
            ) ?? [],
            $fromToIndex => $fromToArray,
        ];
    }
   
    public function bill_delete_purchase($bill_id,$purchase_id)
    {
        $this->repo->deletePurchases($purchase_id);
        return redirect()
            ->route('bill.show',['id'=>$this->repo->find($bill_id)])
            ->with('success','Purchase Deleted');
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
