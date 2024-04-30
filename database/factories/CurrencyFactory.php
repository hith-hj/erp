<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $currency = $this->faker->currencyCode() ;
        return [
            'code'=>$currency,
            'name'=>$currency,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Currency $cur){
            foreach(Currency::where('id','!=',$cur->id)->pluck('id') as $id)
            {
                $cur->rates()->attach($id,['rate'=> rand(5,10)]);
            }
        });
    }

    public function dollar()
    {
        return $this->state(fn(array $attr)=>[
            'name'=>'dollar',
            'code'=>'USD',
        ]);
    }

    public function pound()
    {
        return $this->state(fn(array $attr)=>[
            'name'=>'pound',
            'code'=>'p',
        ]);
    }

    public function syp()
    {
        return $this->state(fn(array $attr)=>[
            'name'=>'syp',
            'code'=>'syp',
        ]);
    }
}
