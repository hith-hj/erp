<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if( is_null( \App\Models\Currency::first() ) ){
            \App\Models\Currency::factory()->dollar()->create();
            \App\Models\Currency::factory()->pound()->create();
            \App\Models\Currency::factory()->syp()->create();
            \App\Models\Currency::factory(2)->create();
        }        
    }
}
