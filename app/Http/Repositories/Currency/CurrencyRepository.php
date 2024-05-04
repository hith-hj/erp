<?php 

namespace App\Http\Repositories\Currency;


use App\Http\Repositories\BaseRepository;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Currency::class);
    }

    public function delete($id):bool
    {
        $currency = $this->findWith($id,'rates');
        $currency->rates()->detach();
        return $currency->delete();
    }
}
