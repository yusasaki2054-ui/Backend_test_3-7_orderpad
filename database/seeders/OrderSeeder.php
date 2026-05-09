<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users    = \App\Models\User::pluck('id')->all();
        $products = \App\Models\Product::pluck('id')->all();

        \App\Models\Order::factory(40)
            ->create()
            ->each(function (\App\Models\Order $order) use ($products) {
                $n     = rand(2, 5);
                $total = 0;

                for ($i = 0; $i < $n; $i++) {
                    $pid  = $products[array_rand($products)];
                    $qty  = rand(1, 4);
                    $unit = rand(100, 5000);

                    $order->items()->create([
                        'product_id' => $pid,
                        'qty'        => $qty,
                        'unit_price' => $unit,
                    ]);

                    $total += $qty * $unit;
                }

                $order->update(['total_amount' => $total]);
            });
    }
}
