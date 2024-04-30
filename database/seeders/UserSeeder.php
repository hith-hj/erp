<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if( is_null( \App\Models\User::first() ) )
        {
            \App\Models\User::firstOrCreate(['email' => 'admin@admin.com',],
                [
                    'username' => 'Admin',
                    'full_name' => 'Ms Admin',
                    'password' => Hash::make('password'),
                ]
            );
            \App\Models\User::factory(5)->create();
        }
        
        if( is_null( \App\Models\Client::first() ) )
        {
            \App\Models\Client::factory(5)->create();
        }
        
        if( is_null( \App\Models\Vendor::first() ) )
        {
            \App\Models\Vendor::factory(5)->create();
        }
    }
}
