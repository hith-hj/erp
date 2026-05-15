<?php

namespace App\Http\Repositories;

use App\Models\Client;
use App\Models\Sale;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Client::class);
    }

    public function getShowPayload($client)
    {
        $request = request();
        $currencies = $this->getter(model: 'currency', columns: ['name']);
        $sales = $this->getFeeds($client, $request);
        $client->records = $this->getRecords($client, $request);

        $sales->currencies = $currencies->map(fn($curency) => $curency->name)->toArray();

        return ['client' => $client, 'sales' => $sales, 'stats' => $this->prepStats($sales, $client)];
    }

    public function prepStats($sales, $client)
    {
        $salesStats = $sales->groupBy(function ($sale) {
            return $sale->currency->name;
        })->map(function ($groupedSales) {
            $firstSale = $groupedSales->first();
            $total = $groupedSales->sum('total');
            $remaining = $groupedSales->sum('remaining');

            return [
                'sales_count'  => $groupedSales->count(),
                'total_credit' => $total,
                'total_debit'  => $remaining,
                'net_balance'  => $total - $remaining,
                'is_default'   => $firstSale->currency->is_default ?? false,
            ];
        });

        $recordsStats = $client->records->groupBy(function ($record) {
            return $record->currency->name;
        })->map(function ($groupedRecords) {
            $firstRecord = $groupedRecords->first();
            $totalCredit = $groupedRecords->where('record_type', 'credit')->sum('quantity');
            $totalDebit  = $groupedRecords->where('record_type', 'debit')->sum('quantity');

            return [
                'records_count' => $groupedRecords->count(),
                'total_credit'  => $totalCredit,
                'total_debit'   => $totalDebit,
                'net_balance'   => $totalCredit - $totalDebit,
                'is_default'    => $firstRecord->currency->is_default ?? false,
            ];
        });

        $allCurrencies = $salesStats->keys()->merge($recordsStats->keys())->unique();

        $combinedStats = [];

        foreach ($allCurrencies as $currency) {
            $saleItem   = $salesStats->get($currency, ['sales_count' => 0, 'total_credit' => 0, 'total_debit' => 0, 'net_balance' => 0, 'is_default' => false]);
            $recordItem = $recordsStats->get($currency, ['records_count' => 0, 'total_credit' => 0, 'total_debit' => 0, 'net_balance' => 0, 'is_default' => false]);

            $totalCredit = $saleItem['total_credit'] + $recordItem['total_credit'];
            $totalDebit  = $saleItem['total_debit'] + $recordItem['total_debit'];
            $netBalance  = $saleItem['net_balance'] + $recordItem['net_balance'];

            $combinedStats[$currency] = [
                'sales_count'   => $saleItem['sales_count'],
                'records_count' => $recordItem['records_count'],
                'total_count'   => $saleItem['sales_count'] + $recordItem['records_count'],
                'total_credit'  => number_format($totalCredit, 2),
                'total_debit'   => number_format($totalDebit, 2),
                'net_balance'   => number_format($netBalance, 2),
                'is_default'    => $saleItem['is_default'] || $recordItem['is_default'],
            ];
        }

        return $combinedStats;
    }

    private function getFeeds($client, $request)
    {
        $sales = Sale::with(['bill.transaction', 'currency'])
            ->when($request->filled('currency'), function ($query) use ($request) {
                $query->whereRelation('currency', 'name', $request->currency);
            })->where('client_id', $client->id)->get();

        return $this->prepareFeeds($sales, $request);
    }

    private function prepareFeeds($sales, $request)
    {
        foreach ($sales as $sale) {
            $sale->hasTransaction = true;
            $sale->remaining = $sale->bill?->transaction?->remaining ?? 0;
            $sale->total = $sale->bill?->transaction?->amount ?? 0;
            if ($sale->bill?->transaction === null) {
                $sale->hasTransaction = false;
            }
            if (! $sale->currency->is_default && $request->filled('defaultCurrencyApplyed')) {
                // $rate = $sale->currency->rate_to_default;
                $rate = $sale->rate;
                $sale->remaining *= $rate;
                $sale->total *= $rate;
            }
        }

        return $sales;
    }

    private function getRecords($client, $request)
    {
        $records = $client->ledgersRecords()
            ->when($request->filled('currency'), function ($query) use ($request) {
                $query->whereRelation('currency', 'name', $request->currency);
            })->get();

        return $this->prepareRecords($records, $request);
    }

    private function prepareRecords($records, $request)
    {
        foreach ($records as $record) {
            if (! $record->currency->is_default && $request->filled('defaultCurrencyApplyed')) {
                // $rate = $record->currency->rate_to_default;
                $matches = [];
                preg_match('/\[rate:(\d+)\]/', $record->note, $matches);
                $record->quantity *= $matches[1] ?? 1;
                $record->note .= 'DEFAULTED';
            }
        }

        return $records;
    }
}
