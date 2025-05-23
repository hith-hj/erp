<?php

namespace App\Http\Controllers\Ledger;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Ledger\LedgerRepository;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    private $repo;

    public function __construct()
    {
        $this->repo = new LedgerRepository();
    }

    public function show(Request $request)
    {
        $request->validate([
            'cashier_id'=>['required','exists:cashiers,id']
        ]);
        
        return view('main.ledger.show',$this->repo->getShowPayload($request));
    }

    public function store(Request $request){
        dd($request->all());
        $request->validate([
            'ledger_items'=>['required','array','min:1'],
            'ledger_items.*.type' => ['required', 'string' , 'in:debit,credit'],
            'ledger_items.*.account' => ['required', 'numeric'],
            'ledger_items.*.currency' => ['required', 'exists:currencies,id'],
            'ledger_items.*.quantity' => ['required', 'numeric', 'min:1'],
            'ledger_items.*.note' => ['nullable', 'string','max:250'],
        ]);

        $this->repo->storeLedgerItems($request->ledger_items);


    }
}
