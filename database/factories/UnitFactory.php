<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->country(),
      'code' => $this->faker->countryCode(),
    ];
  }

  public function kilo()
  {
    return $this->state(fn(array $attr) => [
      'name' => 'kilogram',
      'code' => 'kg',
    ]);
  }

  public function gram()
  {
    return $this->state(fn(array $attr) => [
      'name' => 'gram',
      'code' => 'g',
    ]);
  }

  public function ton()
  {
    return $this->state(fn(array $attr) => [
      'name' => 'ton',
      'code' => 'tn',
    ]);
  }

}
