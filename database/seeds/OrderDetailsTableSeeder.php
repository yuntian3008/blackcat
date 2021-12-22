<?php

use Illuminate\Database\Seeder;

class OrderDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            //factory(App\Product::class, 100)->create();
            factory(App\Order::class, 8000)->create()->each(function ($order) {
                $order->orderDetails()->saveMany(factory(App\OrderDetail::class, mt_rand(1,10))->make());
                foreach ($order->orderDetails as $orderDetail){
                  $orderDetail->review()->save(factory(App\Review::class)->make());
                }
            });

    }
}
