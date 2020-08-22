<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
      
        'name' => $faker->sentence,
        'image' => 'uploads/products/product.png',
        'description' => $faker->paragraph(5),
        'price' => $faker->numberBetween(100, 1000),

    ];
});
