<?php

namespace App\Http\Repositories\Transaction;

use App\Http\Repositories\BaseRepository;
use App\Models\Bill;
use App\Models\Cashier;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends BaseRepository
{
    private $belongTo;
    private $cashier;
    private $transaction;
    private $transaction_types = [
        // adding to the cashier
        'deposit' => 1,
        // subtracting from the cashier
        'withdraw' => 2
    ];

    public function __construct()
    {
        parent::__construct(Transaction::class);
    }

    public function setCashier(int $cashier_id)
    {
        if (is_null($cashier_id)) {
            return $this->throw('Cashier id is required');
        }
        $this->cashier = $this->getter('Cashier', [
            'where' => [['id', $cashier_id]],
        ], 'first');
        if ($this->cashier == null) {
            return $this->throw('cashier not found');
        }
        return $this;
    }

    public function setBelongTo($type = 'bill', $id = null)
    {
        if (is_null($type)) {
            return $this->throw('type is required');
        }
        if (is_null($id)) {
            return $this->throw('id is required');
        }
        $this->belongTo = $this->getter($type, [
            'where' => [['id', $id]],
        ], 'first');
        if ($this->belongTo == null) {
            return $this->throw('belong to not found');
        }
        $this->assertTypeIsSupported();
        $this->assertBillTypeIsSupported();
        return $this;
    }

    public function createTransaction($user = null,$amount = null)
    {
        if (is_null($user)) {
            return $this->throw('User is required');
        }

        $this->transaction = match ($this->belongTo::class) {
            Bill::class => $this->billTransaction($user),
            Cashier::class => $this->cashierTransaction($amount,$user),
            default => $this->assertTypeIsSupported(),
        };
        return $this;
    }

    public function transfer(int $amount = 0, $user = null)
    {
        if (is_null($user)) {
            return $this->throw('User is required');
        }
        $this->assertTransactionIsPossibel();
        $this->assertTransferIsAvailable($amount);
        try {
            DB::beginTransaction();
            $this->transaction->transfers()->create(['amount' => $amount, 'created_by' => $user]);
            $addition = $this->transactionType() === $this->transaction_types['withdraw'] ? false : true;
            $this->updateCashier($this->cashier, $amount, $addition);
            $remaining = $this->transaction->remaining - $amount;
            $is_payed = $remaining === 0 ? true : false;
            $this->transaction->update(['remaining' => $remaining, 'is_payed' => $is_payed]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throw($e->getMessage());
        }
        return $this;
    }

    public function setTransaction($transaction_id = null)
    {
        if (is_null($transaction_id)) {
            return $this->throw('Transaction is required');
        }
        $this->transaction = $this->getter('Transaction', [
            'where' => [['id', $transaction_id]]
        ], 'first');
        $this->setCashier($this->transaction->cashier_id);
        $this->setBelongTo(
            strtolower(class_basename($this->transaction->belongTo_type)),
            $this->transaction->belongTo_id
        );
        return $this;
    }

    private function billTransaction($user)
    {
        $total = $this->getTotal();
        return $this->add([
            'cashier_id' => $this->cashier->id,
            'belongTo_id' => $this->belongTo->id,
            'belongTo_type' => $this->belongTo::class,
            'type' => $this->transactionType(),
            'amount' => $total,
            'remaining' => $total,
            'created_by' => $user,
        ]);
    }

    private function cashierTransaction($amount = null, $user)
    {
        if($amount === null){
            $this->throw('invalid amount');
        }
        $this->add([
            'cashier_id' => $this->cashier->id,
            'belongTo_id' => $this->belongTo->id,
            'belongTo_type' => $this->belongTo::class,
            'type' => $this->transactionType(),
            'amount' => $amount,
            'remaining' => 0,
            'is_payed' => true,
            'created_by' => $user,
        ]);
        $this->updateCashier($this->cashier, $amount);
        $this->updateCashier($this->belongTo, $amount, true);
        return;
    }

    private function getTotal()
    {
        return match ($this->belongTo::class) {
            Bill::class => $this->belongTo->item->total(),
            Cashier::class => $this->cashier->total,
            default => $this->throw('unable to get total'),
        };
    }

    private function transactionType()
    {
        return match ($this->belongTo::class) {
            Cashier::class => $this->transaction_types['withdraw'],
            Bill::class => $this->getBillTransactionType(),
            default => $this->assertTypeIsSupported(),
        };
    }

    private function getBillTransactionType()
    {
        return match ($this->belongTo->billable_type) {
            Sale::class => $this->transaction_types['deposit'],
            Purchase::class => $this->transaction_types['withdraw'],
            default => $this->assertBillTypeIsSupported(),
        };
    }

    private function updateCashier($cashier, $amount, $addition = false)
    {
        if ($addition) {
            return $cashier->update(['total' => $cashier->total + $amount]);
        } else {
            return $cashier->update(['total' => $cashier->total - $amount]);
        }
    }

    private function assertTransactionIsPossibel()
    {
        $total = $this->getTotal();
        if ($this->transactionType() ==  $this->transaction_types['withdraw'] && $total > $this->cashier->total) {
            $this->delete($this->transaction->id);
            return $this->throw('No enough money in this cashier');
        }
    }

    private function assertTransferIsAvailable($amount)
    {
        $remaining = $this->belongTo->item->total() - $amount;
        if ($remaining < 0 || $amount == 0) {
            return $this->throw('the amount you entered is more than the remaining');
        }
    }

    private function assertTypeIsSupported()
    {
        if (!in_array($this->belongTo::class, [Bill::class, Cashier::class])) {
            return $this->throw('Belong to Type is not supported');
        }
    }

    private function assertBillTypeIsSupported()
    {
        if (
            $this->belongTo::class == Bill::class &&
            !in_array($this->belongTo->billable_type, [Purchase::class, Sale::class])
        ) {
            return $this->throw('Bill Type is not supported');
        }
    }

    public function getTransaction()
    {
        return $this->transaction;
    }
}
