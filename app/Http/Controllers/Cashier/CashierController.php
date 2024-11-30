<?php

namespace App\Http\Controllers\Cashier;

use App\DataTables\CashierDataTable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Cashier\CashierRepository;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    private $repo;

    public function __construct()
    {
        $this->repo = new CashierRepository();
    }

    public function index()
    {
        return (new CashierDataTable())->render('main.cashier.index');
    }

    public function show($id){
        // dd($this->repo->getShowPayload($id));
        return view('main.cashier.show',$this->repo->getShowPayload($id));
    }

    public function create(){
        return view('main.cashier.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name'=>['required','string','min:3','max:20'],
            'is_default'=>['nullable','in:true,false'],
        ]);
        $cashier = $this->repo->add($data);
        if(
            (isset($data['is_default']) && (bool)$data['is_default'] === true) ||
            $this->repo->defaultNotExists()
        ){
            $this->repo->setDefault($cashier->id);
        }
        return redirect()->route('cashier.all')->with('success', 'Cashier created');
    }

    public function setDefault($id){
        $this->repo->setDefault($id);
        return redirect()->back()->with('success','Cashier is default');
    }

    public function delete($id){
        $this->repo->delete($id);
        return redirect()->route('cashier.all')->with('success','Cashier is deleted');
    }

    public function transaction(Request $request){
        $data = $request->validate([
            'cashier_id'=>['required','exists:cashiers,id'],
            'bill_id'=>['required','exists:bills,id'],
            'amount'=>['required','numeric','min:0'],
        ]);
        $res = $this->repo->transaction($data['cashier_id'],$data['bill_id'],$data['amount']);
        return redirect()->back()->with(...$res);
    }

    public function transfer(Request $request){
        $data = $request->validate([
            'transaction_id'=>['required','exists:transactions,id'],
            'amount'=>['required','min:0'],
        ]);
        $res = $this->repo->transfers($data['transaction_id'],$data['amount']);
        return redirect()->back()->with(...$res);
    }

    public function credits(Request $request){
        $data = $request->validate([
            'cashier_id'=>['required','exists:cashiers,id'],
            'type'=>['required','in:1,2'],
            'amount'=>['required','numeric'],
        ]);
        $res = $this->repo->credits($data);
        return redirect()->back()->with(...$res);
    }

    public function bill(Request $request) {
        $data = $request->validate([
            'cashier_id'=>['required','exists:cashiers,id'],
            'bill_id'=>['required','exists:bills,id'],
            'amount'=>['required','numeric','min:0'],
        ]);
        $res = $this->repo->transaction($data['cashier_id'],$data['bill_id'],$data['amount']);
        $bill = $this->repo->getter('bill',['with'=>['transaction'],'where'=>[['id',$data['bill_id']]]],'first');
        return redirect()->route('transaction.show',$bill->transaction->id)->with(...$res);
    }
}
