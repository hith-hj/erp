<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if( is_null( \App\Models\Unit::first() ) )
        {
            \App\Models\Unit::factory()->ton()->create();
            \App\Models\Unit::factory()->kilo()->create();
            \App\Models\Unit::factory()->gram()->create();
        }
    }
}
