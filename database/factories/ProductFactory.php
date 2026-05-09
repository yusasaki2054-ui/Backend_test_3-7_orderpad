<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'         => fake()->words(2, true),
            'price'        => fake()->numberBetween(100, 20000),
            'description'  => fake()->optional(0.6)->paragraph(),
            'published_at' => fake()->optional(0.8)->dateTimeBetween('-2 years', 'now'),
        ];
    }
}
