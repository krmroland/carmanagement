<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Users\Models\User;
use Faker\Generator as Faker;
use App\Users\Models\Organization;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'user_id' => factory(User::class),
        'address' => $faker->optional()->address,
        'unique_name' => $faker->unique()->username,
    ];
});
