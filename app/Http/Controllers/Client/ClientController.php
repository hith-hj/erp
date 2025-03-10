<?php

namespace App\Http\Controllers\Client;

use App\DataTables\ClientDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Client\ClientRepository;
use App\Http\Validator\Client\ClientValidator;
use App\Models\Client;
use App\Models\Currency;
use Illuminate\Http\Request;

class ClientController extends BaseController
{
    private $repo;
    public function __construct()
    {
        $this->repo = new ClientRepository();
    }

    public function index()
    {
        return (new ClientDataTable())->render('main.client.index');
    }

    public function show(Request $request, $id)
    {
        $client = Client::with(['sales.materials:id', 'sales.bill.transaction','sales.currency'])
        ->findOrFail($id);
        $currencies = [];
        
        foreach($client->sales as $key=>$sale){
            $sale->defaultCurrencyApplyed = false;
            if($request->filled('currency') && in_array($request->currency,Currency::pluck('name')->toArray())){
                if($sale->currency->name != $request->currency){
                    $client->sales->splice($key, 1);
                }
            }
            if(!in_array($sale->currency->name,$currencies)){
                $currencies[] = $sale->currency->name;
            }

            $sale->remaining = $sale->bill->transaction->remaining;
            $sale->total = $sale->total();
            if(!$sale->currency->is_default && $request->filled('defaultCurrencyApplyed')){
                $rate = $sale->currency->rate_to_default;
                $sale->remaining *= $rate;
                $sale->total *= $rate;
                $sale->defaultCurrencyApplyed = true;
            }
            
        }
        $client->currencies = $currencies;
        return view('main.client.show', ['client' => $client,]);
    }

    public function create()
    {
        return view('main.client.create');
    }

    public function store(Request $request)
    {
        ClientValidator::validate($request);
        foreach ($request->clients as $client) {
            $this->repo->add($client);
        }
        return redirect()->route('client.all')->with('success', 'Client Created');
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()->route('client.all')->with('success', 'Client Deleted');
    }
}
