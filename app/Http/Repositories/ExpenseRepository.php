<?php

namespace App\Http\Repositories;

use App\Models\Expense;

class ExpenseRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Expense::class);
    }

    // public function getExpensesStats(array $data = [])
    // {
    //     $from = (string) $data['from'] ?? null;
    //     $to = (string) $data['to'] ?? null;

    //     $stats = [];
    //     foreach ($data['expenses'] as $id) {
    //         $stats[] = $this->collectExpensStats($id, $from, $to);
    //     }
    //     return $stats;
    // }

    // private function collectExpensStats(Expense|int $expense, ?string $from = null, ?string $to = null)
    // {
    //     $expense = $expense instanceof Expense ? $expense : $this->find($expense);
    //     $withDates = isset($from, $to);

    //     $expense->load([
    //         'accounts' => function ($query) use ($withDates, $from, $to) {
    //             $query->with(['expenses'])
    //                 ->when($withDates, fn($q) => $q->whereBetween('account_expense.created_at', [$from, $to]));
    //         },
    //         'records' => function ($query) use ($withDates, $from, $to) {
    //             $query
    //                 ->with(['currency'])
    //                 ->when($withDates, fn($q) => $q->whereBetween('created_at', [$from, $to]));
    //         },
    //     ]);

    //     $recordsCollection = collect($expense->records);
    //     $totalCredit = $recordsCollection->where('record_type', 'credit')->sum('quantity');
    //     $totalDebit = $recordsCollection->where('record_type', 'debit')->sum('quantity');

    //     return [
    //         'expense_id'   => $expense->id,
    //         'expense_name'   => $expense->name,

    //         'summary' => [
    //             'total_credit'      => (float) $totalCredit,
    //             'total_debit'       => (float) $totalDebit,
    //             'net_balance'       => (float) ($totalDebit - $totalCredit),
    //             'transaction_count' => $recordsCollection->count(),
    //         ],

    //         'accounts' => collect($expense->accounts)->map(fn($account) => [
    //             'id'               => $account->id,
    //             'type'             => $account->type,
    //             'accountable_type' => $account->accountable_type,
    //             'accountable_id'   => $account->accountable_id,
    //         ])->all(),

    //         'ledger_entries' => $recordsCollection->map(fn($record) => [
    //             'id'          => $record->id,
    //             'date'        => \Carbon\Carbon::parse($record->created_at)->toDateTimeString(),
    //             'type'        => $record->record_type,
    //             'amount'      => (float) $record->quantity,
    //             'note'        => $record->note,
    //             'currency_id' => $record->currency?->name ?? $record->currency_id,
    //         ])->values()->all(),

    //     ];
    // }

    public function getExpensesStats(array $data = [])
    {
        $from = isset($data['from']) ? (string) $data['from'] : null;
        $to = isset($data['to']) ? (string) $data['to'] : null;

        $stats = [];
        foreach (($data['expenses'] ?? []) as $id) {
            $stats[] = $this->collectExpensStats($id, $from, $to);
        }
        return $stats;
    }

    private function collectExpensStats(Expense|int $expense, ?string $from = null, ?string $to = null)
    {
        $expense = $expense instanceof Expense ? $expense : $this->find($expense);

        $expense->load([
            'accounts' => function ($query) use ($from, $to) {
                $query->with(['expenses'])
                    ->when($from, fn($q) => $q->where('account_expense.created_at', '>=', $from))
                    ->when($to, fn($q) => $q->where('account_expense.created_at', '<=', $to));
            },
            'records' => function ($query) use ($from, $to) {
                $query->with(['currency'])
                    ->when($from, fn($q) => $q->where('created_at', '>=', $from))
                    ->when($to, fn($q) => $q->where('created_at', '<=', $to));
            },
        ]);

        $recordsCollection = collect($expense->records)->map(function ($record) {
            $record->quantity = $record->currency->is_default ?
                (float) $record->quantity :
                $record->quantity * $record->currency->rate_to_default;
            $record->note = $record->currency->is_default ?
                $record->note :
                'Defaulted - ' . $record->note;
            return $record;
        });
        $totalCredit = $recordsCollection->where('record_type', 'credit')->sum('quantity');
        $totalDebit = $recordsCollection->where('record_type', 'debit')->sum('quantity');

        return [
            'expense_id'   => $expense->id,
            'expense_name' => $expense->name,

            'summary' => [
                'total_credit'      => (float) $totalCredit,
                'total_debit'       => (float) $totalDebit,
                'net_balance'       => (float) ($totalDebit - $totalCredit),
                'transaction_count' => $recordsCollection->count(),
            ],

            'accounts' => collect($expense->accounts)->map(fn($account) => [
                'id'               => $account->id,
                'type'             => $account->type,
                'accountable_type' => $account->accountable_type,
                'accountable_id'   => $account->accountable_id,
                'amount'           => $account->pivot?->cost
            ])->all(),

            'ledger_entries' => $recordsCollection->map(function ($record) {
                return [
                    'id'          => $record->id,
                    'date'        => \Carbon\Carbon::parse($record->created_at)->toDateTimeString(),
                    'type'        => $record->record_type,
                    'amount'      =>  $record->quantity,
                    'note'        => $record->note,
                    'currency' => $record->currency?->name ?? $record->currency_id,
                ];
            })->values()->all(),
        ];
    }
}
