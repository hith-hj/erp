<?php 

namespace App\Http\Repositories\Client;

use App\Http\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Sale;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Client::class);
    }

    public function getShowPayload($id){
        $request = request();
        $currencies = Currency::pluck('name')->toArray();
        $client = Client::findOrFail($id);
        $sales = Sale::with(['bill.transaction','currency'])
        ->when($request->filled('currency'),function($query)use($request){
            $query->whereRelation('currency', 'name', $request->currency);
        })->where('client_id',$client->id)->get();
        
        foreach($sales as $sale){
            $sale->defaultCurrencyApplyed = false;
            $sale->hasTransaction = true;
            $sale->remaining = $sale->bill->transaction?->remaining;
            $sale->total = $sale->bill->transaction?->amount;
            if($sale->bill->transaction === null){
                $sale->hasTransaction = false;
            }
            if(!$sale->currency->is_default && $request->filled('defaultCurrencyApplyed')){
                $rate = $sale->currency->rate_to_default;
                $sale->remaining *= $rate;
                $sale->total *= $rate;
                $sale->defaultCurrencyApplyed = true;
            }
        }
        $sales->currencies = $currencies;
        return ['client' => $client, 'sales'=>$sales];
    }

}