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
        $currency = $this->faker->currencyCode();
        return [
            'code' => $currency,
            'name' => $currency,
            'is_default' => false,
            'rate_to_default' => rand(100,1000),
        ];
    }

    public function dollar()
    {
        return $this->state([
            'name' => 'dollar',
            'code' => 'USD',
            'is_default' => false,
            'rate_to_default' => 1000,
        ]);
    }

    public function pound()
    {
        return $this->state([
            'name' => 'pound',
            'code' => 'p',
            'is_default' => false,
            'rate_to_default' => 1200,
        ]);
    }

    public function syp()
    {
        return $this->state([
            'name' => 'syp',
            'code' => 'syp',
            'is_default' => true,
            'rate_to_default' => 1,            
        ]);
    }
}
