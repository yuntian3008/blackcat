<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\OrderDetail::class, function (Faker $faker) {
    $product_id = $faker->numberBetween($min = 17, $max = 209);
    print("\nPurchased - product_id: ".$product_id);
    return [
        'product_id' => $product_id,
        'quantity' => $faker->numberBetween($min = 1, $max = 20),
    ];
});
