<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Plant;
use Faker\Generator as Faker;

$factory->define(Plant::class, function (Faker $faker) {
    $name = $faker->unique()->words(5,true);
    return [
        'plant_name' => $name,
        'plant_image' => $faker->imageUrl(400,200,'nature'),
        'plant_slug' => str_replace(' ','-',$name),
        'category_id' => $faker->numberBetween(1,3)
    ];
});
