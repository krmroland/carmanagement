<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Products\Entities\Product;
use App\Products\Entities\ProductVariant;

$factory->define(ProductVariant::class, function (Faker $faker) {
    return [
        'image_path' => $faker->optional()->imageUrl(200, 200, 'transport'),
        'identifier' => $faker->unique()->domainWord,
    ];
});

$factory->state(ProductVariant::class, 'withProduct', function ($faker) {
    return ['product_id' => factory(Product::class)];
});
