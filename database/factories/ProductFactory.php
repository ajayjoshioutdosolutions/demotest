<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
         
        return [
            //
            'title' => $this->faker->name(),
            'description' => Str::random(10),
            'price' => rand(50,500),
            'image' => Str::random(10),
            'status' => 'Active',

        ];
    }
}
