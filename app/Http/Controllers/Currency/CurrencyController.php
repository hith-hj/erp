<?php

namespace App\Http\Controllers\Currency;

use App\DataTables\CurrencyDataTable;
use App\Http\Controllers\BaseController;
use App\Models\Currency;
use Illuminate\Http\Request;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class CurrencyController extends BaseController
{
    private $repo ;
    
    public function index()
    {
        $table = new CurrencyDataTable();       
        return $table->render('main.currency.index');
    }

    public function show($id)
    {
        return view('main.currency.show',[
            'currencies'=>Currency::where('id','!=',$id)->get(),
            'currency'=>Currency::with('rates')->find($id),
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
        Currency::create($request->all());
        return redirect()->route('currency.all')->with('success','Currency Added');
    }

    public function currency_rate_store(Request $request)
    {
        $currency = Currency::findOrFail($request->currency_id);
        if(!$currency->rates()->where('rate_to_id',$request->to_id)->exists()){
            $currency->rates()->attach($request->to_id,['rate'=>$request->rate]);
        }else{
            $currency->rates()
                ->syncWithPivotValues($request->to_id,['rate'=>$request->rate],false);
        }
        return redirect()->route('currency.show',['id'=>$currency->id]);
    }
}