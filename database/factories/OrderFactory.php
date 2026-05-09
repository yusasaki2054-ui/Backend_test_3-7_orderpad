<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => \App\Models\User::factory(),
            'order_date'   => fake()->dateTimeBetween('-180 days', 'today'),
            'total_amount' => null,
        ];
    }
}
