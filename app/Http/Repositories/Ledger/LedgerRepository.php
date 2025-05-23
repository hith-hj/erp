<?php

namespace App\Http\Repositories\Ledger;

use App\Http\Repositories\BaseRepository;
use App\Models\Ledger;
use Illuminate\Support\Facades\Auth;

class LedgerRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Ledger::class);
    }

    public function getShowPayload($request){
        return [
            'ledger' => $this->createTodayLedgerIfNotExists($request->input('cashier_id')),
            'currencies' => $this->getter(model: 'currency'),
            'clients'=>$this->getter(model:'client'),
            'vendors'=>$this->getter(model:'vendor'),
        ];
    } 

    public function createTodayLedgerIfNotExists(int $id){
        $cashier = $this->getter(model:'cashier',callable:[
            'where'=>[['id',$id]],
            'with'=>['ledgers']
        ],getter:'first');
        $lastCashierLedger = $cashier->ledgers()->latest()->first();
        if($lastCashierLedger && $lastCashierLedger->created_at->format('Y-m-d') === now()->format('Y-m-d')){
            return $lastCashierLedger->load(['records']);
        }
        return Ledger::create([
            'cashier_id'=>$id,
            'created_by'=>Auth::id(),
            'start_balance'=>$cashier->total,
            'end_balance'=>$cashier->total,
        ]);
    }

    public function storeLedgerItems(array $items)
    {
        foreach($items as $item){
            $this->storeItem($item);
        }
    }

    public function storeItem(array $item){
        
    }

}
