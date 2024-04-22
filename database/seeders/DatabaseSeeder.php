<?php

namespace Database\Seeders;

use Facade\Ignition\Support\FakeComposer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'email'=>'admin@admin.com',
            'password'=>Hash::make('password'),
            ]);
        
        \App\Models\Unit::factory()->createMany(
            [
                [
                    'name'=>'gram',
                    'code'=>'Gr'
                ],
                [
                    'name'=>'kilogram',
                    'code'=>'Kg'
                ],
                [
                    'name'=>'ton',
                    'code'=>'Tn'
                ],                
                [
                    'name'=>'meter',
                    'code'=>'m'
                ]
            ]
        );
        
        $currencies = \App\Models\Currency::factory()->createMany(
            [
                [
                    'name'=>'Dollar',
                    'code'=>'USD',
                ],
                [
                    'name'=>'Pound',
                    'code'=>'P',
                ],
                [
                    'name'=>'Syrian Pound',
                    'code'=>'SYP',
                ]
            ]
        );
        foreach($currencies as $cur)
        {
            $cur->rates()->attach(1,['rate'=> rand(1,5)]);
            $cur->rates()->attach(2,['rate'=> rand(1,5)]);
            $cur->rates()->attach(3,['rate'=> rand(1,5)]);
        }

        $materials = \App\Models\Material::factory(10)->create();
        $inventories = \App\Models\Inventory::factory(10)->create();
        foreach($materials as $key=>$mat)
        {
            $mat->units()->attach(rand(1,4),[
                'is_default'=>$rand = rand(0,1),
                'main_unit'=>$rand==0 ? rand(1,10):0,
                'rate_to_main_unit'=>$rand==0 ? rand(1,30):0
            ]);
            $invo = $inventories[$key];
            $invo->materials()->attach($mat->id,[
                'quantity'=>array_rand([1,2,3,4,5,6,7,8]),
            ]);
        }

        \App\Models\Card::factory(10)->create();        
        \App\Models\Client::factory(5)->create();        
        \App\Models\Vendor::factory(5)->create();        
    }
}
