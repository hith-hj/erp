<?php

namespace App\Http\Repositories\Vendors;

use App\Http\Repositories\BaseRepository;
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
        $purchases = $this->getPurchases($vendor,$request);
        $vendor->records = $this->getRecords($vendor,$request);
        $purchases->currencies = $currencies->map(fn($curency) => $curency->name)->toArray();
        return ['vendor' => $vendor, 'purchases' => $purchases];
    }

    private function getPurchases($vendor,$request)
    {
        $purchases = Purchase::with(['bill.transaction', 'currency'])
            ->when($request->filled('currency'), function ($query) use ($request) {
                $query->whereRelation('currency', 'name', $request->currency);
            })->where('vendor_id', $vendor->id)->get();
        return $this->preparePurchases($purchases,$request);
    }

    private function preparePurchases($purchases,$request)
    {
        foreach ($purchases as $purchase) {
            $purchase->hasTransaction = true;
            $purchase->remaining = $purchase->bill?->transaction?->remaining ?? 0;
            $purchase->total = $purchase->bill?->transaction?->amount ?? 0;
            if ($purchase->bill?->transaction === null) {
                $purchase->hasTransaction = false;
            }
            if (!$purchase->currency->is_default && $request->filled('defaultCurrencyApplyed')) {
                // $rate = $purchase->currency->rate_to_default;
                $rate = $purchase->rate;
                $purchase->remaining *= $rate;
                $purchase->total *= $rate;
            }
        }
        return $purchases;
    }

    private function getRecords($vendor,$request)
    {
        $records = $vendor->ledgersRecords()
            ->when($request->filled('currency'), function ($query) use ($request) {
                $query->whereRelation('currency', 'name', $request->currency);
            })->get();
        return $this->prepareRecords($records,$request);
    }

    private function prepareRecords($records,$request)
    {
        foreach ($records as $record){
            if (!$record->currency->is_default && $request->filled('defaultCurrencyApplyed')) {
                // $rate = $record->currency->rate_to_default;
                $matches = [];
                preg_match('/rate:(\d+):/',$record->note,$matches);
                $record->quantity *= $matches[1];
            }
        }
        return $records;
    }
}
