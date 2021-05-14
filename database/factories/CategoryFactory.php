<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->unique()->words(2, true);
    return [
        'category_name' => $name,
        'category_slug' => str_replace(' ','-',$name),
        'category_image' => $faker->imageUrl(200,200,'nature'),
    ];
});
