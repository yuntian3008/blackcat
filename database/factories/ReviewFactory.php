<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Review::class, function (Faker $faker) {
    $level = $faker->numberBetween($min = 1, $max = 5);
    print("\nRated: ".$level." stars!");
    return [
        'comment' => $faker->paragraph($nbSentences = $faker->numberBetween($min = 2, $max = 6), $variableNbSentences = true),
        'level' => $faker->numberBetween($min = 1, $max = 5),
    ];
});
