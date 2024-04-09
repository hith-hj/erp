<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Material_store_fundtion_()
    {
        $this->withoutExceptionHandling();
        $data = [
            'name'=>'toti',
            'type'=>1,
            'base_unit'=>1,
            'units'=>1,

        ];
        $headers = ['csrf_token'=>csrf_field()];
        $response = $this->post('/material/store',$data,$headers );

        $response->assertStatus(200);
        // it('can list products', function () {
        //     getJson('/products')->assertStatus(200);
        // });
        // it('can create a product', function () {
        //     $data = [
        //         'name' => 'Product 1',
        //         'price' => 100
        //     ];
        //     // 201 http created
        //     postJson('/products/create',$data)->assertStatus(201);
        // });
    }
}
