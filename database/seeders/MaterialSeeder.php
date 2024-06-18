<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if( is_null( \App\Models\Material::first() ) )
        {
            \App\Models\Material::factory(10)->create();
            \App\Models\Material::factory(2)->base()->create();
            \App\Models\Material::factory(2)->manufactured()->create();
        }
    }
}
