<?php 

namespace App\Http\Repositories\Vendors;

use Illuminate\Database\Eloquent\Collection;
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
        $purchases = Purchase::with(['bill.transaction', 'currency'])
            ->when($request->filled('currency'), function ($query) use ($request) {
                $query->whereRelation('currency', 'name', $request->currency);
            })->where('vendor_id', $vendor->id)->get();

        foreach ($purchases as $purchase) {
            $purchase->hasTransaction = true;
            $purchase->remaining = $purchase->bill?->transaction?->remaining ?? 0;
            $purchase->total = $purchase->bill?->transaction?->amount ?? 0;
            if ($purchase->bill?->transaction === null) {
                $purchase->hasTransaction = false;
            }
            if (!$purchase->currency->is_default && $request->filled('defaultCurrencyApplyed')) {
                $rate = $purchase->currency->rate_to_default;
                $purchase->remaining *= $rate;
                $purchase->total *= $rate;
            }
        }
        $purchases->currencies = $currencies->map(fn($curency)=> $curency->name)->toArray();
        return ['vendor' => $vendor, 'purchases' => $purchases];
    }

}
