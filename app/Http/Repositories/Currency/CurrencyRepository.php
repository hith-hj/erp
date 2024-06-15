<?php

namespace App\Http\Repositories\Currency;


use App\Http\Repositories\BaseRepository;
use App\Models\Currency;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Currency::class);
    }

    public function getShowPayload($id)
    {
        return ['currency' => $this->find($id),];
    }

    public function delete($id): bool
    {
        $currency = $this->find($id);
        if($currency->is_default ){
            throw new Exception('Default currency can\'t be deleted');
            return false;
        }
        return $currency->delete() ;
    }
}
