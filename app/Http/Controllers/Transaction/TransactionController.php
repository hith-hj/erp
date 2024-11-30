<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Transaction\TransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $repo;


    public function __construct()
    {
        $this->repo = new TransactionRepository();
    }

    public function index() 
    {
        return redirect()->route('cashier.all');   
    }

    public function show($id)
    {
        $data = [ 
            'transaction '=> $this->repo->getter('Transaction',[
                'with'=>['transfers'],
                'where'=>[['id',$id],]
            ],'first')
        ];
        $transaction = $this->repo->getter('Transaction',[
            'with'=>['transfers'],
            'where'=>[['id',$id],]
        ],'first'); 
        return view('main.Transaction.show',compact('transaction'));
    }
}
