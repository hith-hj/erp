<?php

namespace App\Http\Repositories\Client;

use App\Http\Repositories\BaseRepository;
use App\Models\Client;
use App\Models\Sale;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Client::class);
    }

    public function getShowPayload($id)
    {
        $request = request();
        $currencies = $this->getter(model: 'currency', columns: ['name']);
        $client = $this->getter(model: 'client', callable: [
            'where' => [['id', $id]]
        ], getter: 'firstOrFail');
        $sales = Sale::with(['bill.transaction', 'currency'])
            ->when($request->filled('currency'), function ($query) use ($request) {
                $query->whereRelation('currency', 'name', $request->currency);
            })->where('client_id', $client->id)->get();

        foreach ($sales as $sale) {
            $sale->hasTransaction = true;
            $sale->remaining = $sale->bill?->transaction?->remaining ?? 0;
            $sale->total = $sale->bill?->transaction?->amount ?? 0;
            if ($sale->bill?->transaction === null) {
                $sale->hasTransaction = false;
            }
            if (!$sale->currency->is_default && $request->filled('defaultCurrencyApplyed')) {
                $rate = $sale->currency->rate_to_default;
                $sale->remaining *= $rate;
                $sale->total *= $rate;
            }
        }
        $sales->currencies = $currencies->map(fn($curency)=> $curency->name)->toArray();
        return ['client' => $client, 'sales' => $sales];
    }

}