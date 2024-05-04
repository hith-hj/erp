<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            UnitSeeder::class,
            CurrencySeeder::class,
            MaterialSeeder::class,
            InventorySeeder::class,
        ]);

        \App\Models\AccountType::factory()->createMany([
            ['name'=>'Manufacturing',],
            ['name'=>'Shipping',],
            ['name'=>'Transportation',],
            ['name'=>'Other',]
        ]);
        \App\Models\Expense::factory(5)->create();
    }
}
