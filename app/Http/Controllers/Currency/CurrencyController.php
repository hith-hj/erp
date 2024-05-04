<?php

namespace App\Http\Controllers\Currency;

use App\DataTables\CurrencyDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Currency\CurrencyRepository;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends BaseController
{
    private $repo ;
    public function __construct()
    {
        $this->repo = new CurrencyRepository(); 
    } 
    public function index()
    {
        $table = new CurrencyDataTable();       
        return $table->render('main.currency.index');
    }

    public function show($id)
    {
        return view('main.currency.show',[
            'currencies'=>Currency::where('id','!=',$id)->get(),
            'currency'=>$this->repo->findWith($id,'rates'),
        ]);
    }

    public function create()
    {
        return view('main.currency.create');   
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','string','unique:currencies,name'],
            'code'=>['required','string'],
        ]);
        $this->repo->add($request->only(['name','code']));
        return redirect()->route('currency.all')->with('success','Currency Added');
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()
            ->route('currency.all')
            ->with('success','currency deleted');
    }

    public function currency_rate_store(Request $request)
    {
        $currency = $this->repo->find($request->currency_id);
        if(!$currency->rates()->where('rate_to_id',$request->to_id)->exists()){
            $currency->rates()->attach($request->to_id,['rate'=>$request->rate]);
        }else{
            $currency->rates()
                ->syncWithPivotValues($request->to_id,['rate'=>$request->rate],false);
        }
        return redirect()->route('currency.show',['id'=>$currency->id]);
    }
}