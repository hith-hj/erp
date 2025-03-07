<?php

namespace App\Http\Controllers\Client;

use App\DataTables\ClientDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Client\ClientRepository;
use App\Http\Validator\Client\ClientValidator;
use App\Models\Client;
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

    public function show($id)
    {
        $client = Client::with(['sales.materials', 'sales.bill.transaction','sales.currency'])->findOrFail($id);
        foreach($client->sales as $sale){
            $remaining = $sale->bill->transaction->remaining;
            $total = $sale->total();
            if(!$sale->currency->is_default){
                $rate = $sale->currency->rate_to_default;
                $sale->remaining = $remaining * $rate;
                $sale->total = $total * $rate;
            }else{
                $sale->remaining = $remaining;
                $sale->total = $total;
            }
            
        }
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
