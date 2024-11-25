<?php

namespace App\Http\Repositories\Transaction;

use App\Http\Repositories\BaseRepository;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends BaseRepository
{
    private $bill;
    private $cashier;
    private $transaction;
    private $transaction_types = ['Deposit' => 1, 'withdraw' => 2];

    public function __construct()
    {
        parent::__construct(Transaction::class);
    }

    public function setCashier(int $cashier_id)
    {
        if(is_null($cashier_id)){
            return $this->throw('Cashier is required');
        }
        $this->cashier = $this->getter('Cashier', [
            'where' => [['id', $cashier_id]],
        ], 'first');
        return $this;
    }

    public function setBill($bill_id = null)
    {
        if(is_null($bill_id)){
            return $this->throw('Bill is required');
        }
        $this->bill = $this->getter('Bill', [
            'where' => [['id', $bill_id]],
        ], 'first');
        return $this;
    }
    
    public function createTransaction($user = null )
    {
        if(is_null($user)){
            return $this->throw('User is required');
        }
        $total = $this->bill->item->total();
        $this->transaction = $this->add([
            'cashier_id' => $this->cashier->id,
            'bill_id' => $this->bill->id,
            'type' => $this->transactionType(),
            'amount' => $total,
            'remaining' => $total,
            'created_by' => $user,
        ]);
        return $this;
    }

    public function setTransaction($transaction_id = null)
    {
        if(is_null($transaction_id)){
            return $this->throw('Transaction is required');
        }
        $this->transaction = $this->getter('Transaction', [
            'where' => [['id', $transaction_id]]
        ], 'first');
        $this->setCashier($this->transaction->cashier_id);
        $this->setBill($this->transaction->bill_id);
        return $this;
    }

    public function transfer(int $amount = 0, $user = null)
    {
        if(is_null($user)){
            return $this->throw('User is required');
        }
        $this->assertTransactionIsPossibel();
        $this->assertTransferIsAvailable($amount);
        try {
            DB::beginTransaction();
            $this->transaction->transfers()->create(['amount' => $amount,'created_by'=>$user]);
            $this->cashier->update([
                'total' => $this->transactionType() == $this->transaction_types['Deposit'] ? 
                $this->cashier->total + $amount : 
                $this->cashier->total - $amount 
            ]);
            $this->transaction->update(['remaining' => $this->transaction->remaining - $amount]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throw($e->getMessage());
        }
        return $this;
    }

    public function transactionType()
    {
        return match ($this->bill->billable_type) {
            Sale::class => 1,
            Purchase::class => 2,
        };
    }

    public function assertTransactionIsPossibel()
    {
        $total = $this->bill->item->total();
        if ($this->transactionType() ==  $this->transaction_types['withdraw'] && $total > $this->cashier->total) {
            $this->delete($this->transaction->id);
            return $this->throw('No enough money in this cashier');
        }
    }

    private function assertTransferIsAvailable($amount)
    {
        $remaining = $this->bill->item->total() - $amount;
        if ($remaining < 0 || $amount == 0) {
            return $this->throw('the amount you entered is more than the remaining');
        }
    }
}
