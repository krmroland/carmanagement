<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Products\Models\Product;
use App\Products\Models\ProductVariant;

$factory->define(ProductVariant::class, function (Faker $faker) {
    return [
        'product_id' => factory(Product::class),
        'image_path' => $faker->optional()->imageUrl(200, 200, 'transport'),
        'identifier' => $faker->unique()->domainWord,
    ];
});
