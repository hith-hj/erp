<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(is_null(\App\Models\Inventory::first()))
        {
            \App\Models\Inventory::factory(5)->create();
        }
    }
}
