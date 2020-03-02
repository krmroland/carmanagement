<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Users\Models\User;
use Faker\Generator as Faker;
use App\Tenants\Models\Tenant;

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'email' => $faker->unique()->optional()->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone_number' => $faker->phoneNumber,
    ];
});
