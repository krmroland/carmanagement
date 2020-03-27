<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Users\Entities\User;
use Faker\Generator as Faker;
use App\Tenants\Entities\Tenant;

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'account_id' => fn() => factory(User::class)->create()->account,
        'email' => $faker->unique()->optional()->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone_number' => $faker->phoneNumber,
    ];
});
