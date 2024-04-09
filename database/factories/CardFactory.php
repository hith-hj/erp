<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = \App\Models\User::factory(1)->create()[0];
        return [
            'user_id'=>$user->id,
            'code'=>$this->faker->numberBetween(1000,1000000),
            'name'=>$this->faker->name,
            'type'=>$this->faker->randomElement(['shift','build','sales']),
            'note'=>$this->faker->text,
        ];
    }
}
