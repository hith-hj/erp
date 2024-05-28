<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'full_name' => $this->faker->firstName().'_'.$this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'device_token'=>'pindding',
            // 'section_id'=> \App\Models\Section::factory(1)->create()[0]['id'],

        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(User $user){
            $user->settings()->create(['key' => 'phone_number', 'value' => $this->faker->phoneNumber()]);
        });
    }
}
