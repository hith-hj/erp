<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [ 
            'first_name'=>$this->faker->firstName(),
            'last_name'=>$this->faker->firstName(),
            'email'=>$this->faker->email(),
            'phone'=>$this->faker->phoneNumber(),
        ];
    }
}
