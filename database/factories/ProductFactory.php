<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Components\Helper\ImageProcessing;
use App\Components\Helper\Slugger;
use App\Category;

$factory->define(App\Product::class, function (Faker $faker) {
    $imgProcess = new ImageProcessing();
    print("\n\n\n\n");
    $image = file_get_contents('https://loremflickr.com/600/600/coffee-mug');
    print("Loaded Image!\n");
    $product_image = $imgProcess->run($image,'products');
    $product_name = $faker->words($nb = $faker->numberBetween($min = 3, $max = 10), $asText = true).mt_rand(1,1000);
    $product_price = $faker->numberBetween($min = 1, $max = 10000);
    $product_slug = Slugger::make($product_name);
    $product_desc = $faker->paragraph($nbSentences = mt_rand(5,12), $variableNbSentences = true);
    $category_id = $faker->numberBetween($min = 2, $max = 17);
    
    print("===== PRODUCT =====\n");
    print(" + name : ".$product_name."\n");
    print(" + image : ".$product_image."\n");
    print(" + price : ".$product_price."\n");
    print(" + slug : ".$product_slug."\n");
    print(" + desc : ".$product_desc."\n");
    print(" + category : ".Category::find($category_id)->category_name."\n");
    return [
        'product_name' => $product_name,
        'product_image' => $product_image,
        'product_price' => $product_price,
        'product_slug' => $product_slug,
        'product_desc' => $product_desc,
        'category_id' => $category_id,
    ];
});
