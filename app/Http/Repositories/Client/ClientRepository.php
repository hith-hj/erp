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

    public function getShowPayload($client)
    {
        $request = request();
        $currencies = $this->getter(model: 'currency', columns: ['name']);
        $sales = $this->getFeeds($client,$request);
        $client->records = $this->getRecords($client,$request);

        $sales->currencies = $currencies->map(fn($curency) => $curency->name)->toArray();
        return ['client' => $client, 'sales' => $sales];
    }

    private function getFeeds($client,$request)
    {
        $sales = Sale::with(['bill.transaction', 'currency'])
            ->when($request->filled('currency'), function ($query) use ($request) {
                $query->whereRelation('currency', 'name', $request->currency);
            })->where('client_id', $client->id)->get();
        return $this->prepareFeeds($sales,$request);
    }

    private function prepareFeeds($sales,$request)
    {
        foreach ($sales as $sale) {
            $sale->hasTransaction = true;
            $sale->remaining = $sale->bill?->transaction?->remaining ?? 0;
            $sale->total = $sale->bill?->transaction?->amount ?? 0;
            if ($sale->bill?->transaction === null) {
                $sale->hasTransaction = false;
            }
            if (!$sale->currency->is_default && $request->filled('defaultCurrencyApplyed')) {
                // $rate = $sale->currency->rate_to_default;
                $rate = $sale->rate;
                $sale->remaining *= $rate;
                $sale->total *= $rate;
            }
        }
        return $sales;
    }

    private function getRecords($client,$request)
    {
        $records = $client->ledgersRecords()
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
