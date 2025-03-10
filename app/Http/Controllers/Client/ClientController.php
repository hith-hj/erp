<?php

namespace App\Http\Controllers\Client;

use App\DataTables\ClientDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Client\ClientRepository;
use App\Http\Validator\Client\ClientValidator;
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

    public function show(Request $request,$id)
    {
        $request->validate([
            'currency'=>['sometimes','string','exists:currencies,name'],
        ]);
        return view('main.client.show', $this->repo->getShowPayload($id));
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
