<?php

namespace App\Http\Repositories\Ledger;

use App\Http\Repositories\BaseRepository;
use App\Models\Ledger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LedgerRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Ledger::class);
    }

    public function getCashierLedgersPayload($cashier_id)
    {
        $validator = Validator::make(
            ['cashier_id' => $cashier_id],
            ['cashier_id' => ['required', 'exists:cashiers,id']],
        );
        $cashier = $this->getter(
            model: 'cashier',
            callable: [
                'where' => [['id', $validator->validated()['cashier_id']]],
                'with' => ['ledgers.admin'],
            ],
            getter: 'first'
        );
        throw_if($cashier === null ,'cashier not found');
        return ['cashier' => $cashier];
    }

    public function getTodayPayload($cashier_id)
    {
        $validator = Validator::make(
            ['cashier_id' => $cashier_id],
            ['cashier_id' => ['required', 'exists:cashiers,id']],
        );
        $ledger = $this->createTodayLedgerForCashierIfNotExists($validator->validated()['cashier_id']);
        throw_if($ledger === null ,'ledger not found');
        return [
            'ledger' => $ledger,
            'currencies' => $this->getter(model: 'currency'),
            'clients' => $this->getter(model: 'client'),
            'vendors' => $this->getter(model: 'vendor'),
        ];
    }

    public function createTodayLedgerForCashierIfNotExists(int $id)
    {
        $cashier = $this->getter(model: 'cashier', callable: [
            'where' => [['id', $id]],
        ], getter: 'first');
        throw_if($cashier === null ,'cashier not found');
        $ledgers = $cashier->ledgers()->orderBy('created_at', 'desc')->get();
        if(($last = $ledgers->first())->created_at->format('Y-m-d') === now()->format('Y-m-d')){
            $ledger = $last;
        }else{
            $ledger = $this->add([
                'cashier_id' => $id,
                'created_by' => Auth::id(),
                'start_balance' => $cashier->total,
                'end_balance' => $cashier->total,
            ]);
        }
        throw_if($ledger === null ,'ledger not found');
        return $ledger->load(['records.currency']);
    }

    public function getLedgerRecordsPayload($ledger_id)
    {
        return ['ledger' => $this->getLedger($ledger_id),];
    }

    public function getLedger($id)
    {
        $ledger = $this->getter(
            model: 'ledger',
            callable: [
                'where' => [['id', $id],],
                'with' => ['records.currency']
            ],
            getter: 'first'
        );
        throw_if($ledger === null ,'ledger not found');

        return $ledger;
    }

    public function storeLedgerRecords(Ledger $ledger, array $records)
    {
        foreach ($records as $record) {
            $this->storeItem($ledger, $record);
        }
    }

    public function storeItem(Ledger $ledger, array $record)
    {
        if($record['record_type'] === 'credit'){
            $ledger->cashier()->increment('total',$record['quantity']);
            $ledger->increment('end_balance',$record['quantity']);
        }else{
            $ledger->cashier()->decrement('total',$record['quantity']);
            $ledger->decrement('end_balance',$record['quantity']);
        }
        return $ledger->records()->create($record);
    }

    public function checkForDuplicates(array $records)
    {
        for ($i = 0; $i < count($records); $i++) {
            for ($j = $i + 1; $j < count($records); $j++) {
                if (
                    $records[$i]['account_id'] == $records[$j]['account_id'] &&
                    $records[$i]['currency_id'] == $records[$j]['currency_id'] &&
                    $records[$i]['record_type'] == $records[$j]['record_type']
                ) {
                    $records[$i]['quantity'] = $records[$i]['quantity'] + $records[$j]['quantity'];
                    array_splice($records, $j, 1);
                }
            }
        }
        return $records;
    }

    public function checkAccounts(array $records)
    {
        for ($i = 0; $i < count($records); $i++) {
            $type = $records[$i]['record_type'] === 'debit' ? 'vendor' : 'client';
            $account = $this->getter($type, ['where' => [['id', $records[$i]['account_id']]]], 'first');
            throw_if(!$account, "Account $type Not Found");
            $records[$i]['account_type'] = $type;
        }
        return $records;
    }

    public function setToDefaultCurrency(array $records)
    {
        for ($i = 0; $i < count($records); $i++) {
            $currency = $this->getter('currency', ['where' => [['id', $records[$i]['currency_id']]]], 'first');
            throw_if(!$currency, "Currency Not Found");
            if (! $currency->is_default) {
                $records[$i]['quantity'] *= $currency->rate_to_default;
            }
        }
        return $records;
    }
}
