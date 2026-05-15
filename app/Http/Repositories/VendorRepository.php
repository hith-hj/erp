<?php

namespace App\Http\Repositories;

use App\Models\Purchase;
use App\Models\Vendor;

class VendorRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Vendor::class);
    }

    public function getShowPayload($vendor)
    {
        $request = request();
        $currencies = $this->getter(model: 'currency', columns: ['name']);
        $purchases = $this->getPurchases($vendor, $request);
        $vendor->records = $this->getRecords($vendor, $request);
        $purchases->currencies = $currencies->map(fn($curency) => $curency->name)->toArray();

        return ['vendor' => $vendor, 'purchases' => $purchases, 'stats' => $this->prepStats($purchases, $vendor)];
    }

    public function prepStats($purchases, $client)
    {
        $purchaseStats = $purchases->groupBy(function ($purchase) {
            return $purchase->currency->name;
        })->map(function ($groupedPurchases) {
            $firstPurchase = $groupedPurchases->first();
            $total = $groupedPurchases->sum('total');
            $remaining = $groupedPurchases->sum('remaining');

            return [
                'purchases_count' => $groupedPurchases->count(),
                'total_credit'    => $total,
                'total_debit'     => $total - $remaining,
                'net_balance'     => $remaining,
                'is_default'      => $firstPurchase->currency->is_default ?? false,
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

        $allCurrencies = $purchaseStats->keys()->merge($recordsStats->keys())->unique();

        $combinedStats = [];

        foreach ($allCurrencies as $currency) {
            $purchaseItem = $purchaseStats->get($currency, ['purchases_count' => 0, 'total_credit' => 0, 'total_debit' => 0, 'net_balance' => 0, 'is_default' => false]);
            $recordItem   = $recordsStats->get($currency, ['records_count' => 0, 'total_credit' => 0, 'total_debit' => 0, 'net_balance' => 0, 'is_default' => false]);

            $totalCredit = $purchaseItem['total_credit'] + $recordItem['total_credit'];
            $totalDebit  = $purchaseItem['total_debit'] + $recordItem['total_debit'];
            $netBalance  = $purchaseItem['net_balance'] + $recordItem['net_balance'];

            $combinedStats[$currency] = [
                'purchases_count' => $purchaseItem['purchases_count'],
                'records_count'   => $recordItem['records_count'],
                'total_count'     => $purchaseItem['purchases_count'] + $recordItem['records_count'],
                'total_credit'    => number_format($totalCredit, 2),
                'total_debit'     => number_format($totalDebit, 2),
                'net_balance'     => number_format($netBalance, 2),
                'is_default'      => $purchaseItem['is_default'] || $recordItem['is_default'],
            ];
        }

        return $combinedStats;
    }


    private function getPurchases($vendor, $request)
    {
        $purchases = Purchase::with(['bill.transaction', 'currency'])
            ->when($request->filled('currency'), function ($query) use ($request) {
                $query->whereRelation('currency', 'name', $request->currency);
            })->where('vendor_id', $vendor->id)->get();

        return $this->preparePurchases($purchases, $request);
    }

    private function preparePurchases($purchases, $request)
    {
        foreach ($purchases as $purchase) {
            $purchase->hasTransaction = true;
            $purchase->remaining = $purchase->bill?->transaction?->remaining ?? 0;
            $purchase->total = $purchase->bill?->transaction?->amount ?? 0;
            if ($purchase->bill?->transaction === null) {
                $purchase->hasTransaction = false;
            }
            if (! $purchase->currency->is_default && $request->filled('defaultCurrencyApplyed')) {
                // $rate = $purchase->currency->rate_to_default;
                $rate = $purchase->rate;
                $purchase->remaining *= $rate;
                $purchase->total *= $rate;
            }
        }

        return $purchases;
    }

    private function getRecords($vendor, $request)
    {
        $records = $vendor->ledgersRecords()
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
