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
            'cashiers' => $this->getter('cashier', [
                'where' => [['id', '!=', $id]]
            ]),
            'cashierTransactions' => $this->getter('transaction', [
                'where' => [['belongTo_id',$id],['belongTo_type',Cashier::class]]
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

    public function transaction($cashier_id, $type, $id, $amount)
    {
        try {
            $transaction = new TransactionRepository();
            $transaction->setCashier($cashier_id)
                ->setBelongTo($type,$id)
                ->createTransaction(auth()->id(),$amount);
            if(in_array($type,['bill'])){
                $transaction->transfer($amount, auth()->id());
            }
        } catch (\Exception $e) {
            return ['error', $e->getMessage()];
        }
        return ['success', 'Transaction is started'];
    }

    public function transfers($transaction_id, $amount)
    {
        try {
            $transaction = new TransactionRepository();
            $transaction->setTransaction($transaction_id)->transfer($amount, auth()->id());
        } catch (\Exception $e) {
            return ['error', $e->getMessage()];
        }
        return ['success', 'Transfer is stored'];
    }

}
