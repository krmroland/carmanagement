<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Users\Entities\User;
use Faker\Generator as Faker;
use App\Products\Models\Product;
use App\Products\Models\ProductVariant;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'type' => $faker->randomElement(['house', 'car']),
        'currency' => 'UGX',
        'user_id' => factory(User::class),
    ];
});

$factory->state(Product::class, 'withVariantData', function (Faker $faker) {
    return [
        'variant_fields' => factory(ProductVariant::class)->raw(),
    ];
});
