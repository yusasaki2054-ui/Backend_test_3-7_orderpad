<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id'   => \App\Models\Order::factory(),
            'product_id' => \App\Models\Product::factory(),
            'qty'        => fake()->numberBetween(1, 5),
            'unit_price' => fake()->numberBetween(100, 20000),
        ];
    }
}
