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

    public function getShowPayload($id)
    {
        return [
            'currencies' => $this->getter(
                model: 'Currency',
                callable: [
                    'where' => [['id', '!=', $id]]
                ],
            ),
            'currency' => $this->findWith($id, 'rates'),
        ];
    }

    public function delete($id): bool
    {
        $currency = $this->findWith($id, 'rates');
        $currency->rates()->detach();
        return $currency->delete();
    }
}
