<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Users\Entities\User;
use Faker\Generator as Faker;
use App\Products\Entities\Product;
use App\Products\Entities\ProductVariant;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'type' => $faker->randomElement(['house', 'car']),
        'currency' => 'UGX',
        'account_id' => fn() => factory(User::class)->create()->account,
    ];
});

$factory->state(Product::class, 'withVariantData', function (Faker $faker) {
    return [
        'variant_fields' => factory(ProductVariant::class)->raw(),
    ];
});
