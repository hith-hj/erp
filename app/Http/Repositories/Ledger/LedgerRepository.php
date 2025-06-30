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
        throw_if($cashier === null, 'cashier not found');
        return ['cashier' => $cashier];
    }

    public function getTodayPayload($cashier_id)
    {
        $validator = Validator::make(
            ['cashier_id' => $cashier_id],
            ['cashier_id' => ['required', 'exists:cashiers,id']],
        );
        $ledger = $this->createTodayLedgerForCashierIfNotExists($validator->validated()['cashier_id']);
        throw_if($ledger === null, 'ledger not found');
        return [
            'ledger' => $ledger,
            'currencies' => $this->getter(model: 'currency'),
            'clients' => $this->getter(model: 'client'),
            'vendors' => $this->getter(model: 'vendor'),
            'expences' => $this->getter(model: 'expense'),
        ];
    }

    public function createTodayLedgerForCashierIfNotExists(int $id)
    {
        $cashier = $this->getter(model: 'cashier', callable: [
            'where' => [['id', $id]],
        ], getter: 'first');
        throw_if($cashier === null, 'cashier not found');
        $ledgers = $cashier->ledgers()->orderBy('created_at', 'desc')->get();
        if (($last = $ledgers->first())?->created_at->format('Y-m-d') === now()->format('Y-m-d')) {
            $ledger = $last;
        } else {
            $ledger = $this->add([
                'cashier_id' => $id,
                'created_by' => Auth::id(),
                'start_balance' => $cashier->total,
                'end_balance' => $cashier->total,
            ]);
        }
        throw_if($ledger === null, 'ledger not found');
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
        throw_if($ledger === null, 'ledger not found');

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
        $defaulted = $this->setToDefaultCurrency($record);
        if ($record['record_type'] === 'credit') {
            $ledger->cashier()->increment('total', $defaulted['quantity']);
            $ledger->increment('end_balance', $record['quantity']);
        } else {
            $ledger->cashier()->decrement('total', $defaulted['quantity']);
            $ledger->decrement('end_balance', $record['quantity']);
        }
        $record['note'] .= $defaulted['note'];
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
            $record = $this->getRecordType($records[$i]);
            $type = $record['account_type'];
            $account = $this->getter(
                model: $type,
                callable: [
                    'where' => [
                        ['id', $record['account_id'] ],
                    ]
                ],
                getter: 'first',
            );
            $record['account_type'] = $account::class;
            $records[$i]=$record;
        }
        return $records;
    }

    private function getRecordType(array $record)
    {
        [$type, $id] = explode('_', $record['account_id']);
        throw_if(!isset($type, $id), 'invalid record info');
        $record['account_id'] = $id;
        $record['account_type'] = $type;
        return $record;
    }

    public function setToDefaultCurrency(array $record)
    {
        $currency = $this->getter('currency', ['where' => [['id', $record['currency_id']]]], 'first');
        throw_if(!$currency, "Currency Not Found");
        if (! $currency->is_default) {
            $record['quantity'] *= $currency->rate_to_default;
            $record['note'] .= " defaulted: rate- {$currency->rate_to_default}";
        }
        return $record;
    }
}
