<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Order::class, function (Faker $faker) {
    $now = Carbon::now();
    $request_date = $now->subDays($faker->numberBetween($min = 16, $max = 730));
    $get_date = $request_date->addDays($faker->numberBetween($min = 1, $max = 4));
    $ship_date = $get_date->addDays($faker->numberBetween($min = 1, $max = 4));
    $completion_date = $ship_date->addDays($faker->numberBetween($min = 1, $max = 4));
    print("\n\n=============\n----Order created at: ".$request_date);
    return [
        'customer_id' => $faker->numberBetween($min = 2, $max = 4),
        'request_date' => $request_date,
        'get_date' => $get_date,
        'ship_date' => $ship_date,
        'completion_date'=> $completion_date, 
        'payment' =>  $faker->randomElement($array = array ('momo','cash','card','zalo')),
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
    ];
});
