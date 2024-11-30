<?php

namespace App\Http\Repositories\Cashier;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Transaction\TransactionRepository;
use App\Models\Cashier;
use App\Models\Manufacturing;
use App\Models\Transfer;

class CashierRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Cashier::class);
    }

    public function defaultNotExists()
    {
        return $this->getter('cashier', ['where' => [['is_default', true]]])->isEmpty();
    }

    public function getShowPayload($id)
    {
        return [
            'cashier' => $this->findWith($id, ['transactions.transfers']),
            'bills' => $this->getter('Bill', [
                'doesntHave' => 'transaction',
                'where' => [['billable_type', '!=', Manufacturing::class]],
            ]),
            'cashier_transfers'=>$this->getter('Transfer',[
                'where'=>[['transaction_id','LIKE','%9900'.$id.'0099%']]
            ])
        ];
    }

    public function setDefault($id)
    {
        $new = $this->find($id);
        $default = $this->getter('Cashier', ['where' => [['is_default', '=', '1']]]);
        if (!$default->isEmpty()) {
            $default->each(function ($model) {
                $model->update(['is_default' => 0]);
            });
        }
        return $new->update(['is_default' => 1]);
    }

    public function transaction($cashier_id, $bill_id, $amount)
    {
        try {
            $transaction = new TransactionRepository();
            $transaction->setCashier($cashier_id)
            ->setBill($bill_id)
            ->createTransaction(auth()->id())
            ->transfer($amount,auth()->id());
        } catch (\Exception $e) {
            return ['error',$e->getMessage()];
        }
        return ['success', 'Transaction is started'];
    }
    
    public function transfers($transaction_id, $amount){
        try {
            $transaction = new TransactionRepository();
            $transaction->setTransaction($transaction_id)->transfer($amount,auth()->id());
        } catch (\Exception $e) {
            return ['error',$e->getMessage()];
        }
        return ['success', 'Transfer is stored'];
    }

    public function credits($data){
        $cashier = $this->getter('Cashier',['where'=>[['id',$data['cashier_id']],] ],'first');
        if($data['type'] == 2 && $cashier->total < $data['amount']){
            return ['error','No enough money in this cashier'];
        }
        $cashier->update([
            'total'=> $data['type'] == 2 ? 
            $cashier->total - $data['amount'] :
            $cashier->total + $data['amount'] ]);
        $id = "9900$cashier->id"."0099"."66".$data['type']."66". rand(000,999);
        $transfers = Transfer::create([
            'transaction_id'=> $id,
            'amount'=>$data['amount'],
            'created_by'=>auth()->id()
        ]);
        return ['success','Money is transfered'];        
    }
}
