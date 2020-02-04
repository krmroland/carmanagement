<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Users\Models\User;
use Faker\Generator as Faker;
use App\Projects\Models\Project;
use App\Users\Models\Organization;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'type' => $faker->randomElement(['house', 'car']),
        'image_path' => $faker->optional()->imageUrl(200, 200, 'transport'),
        'identifier' => $faker->optional()->domainWord,
        'currency' => 'UGX',
    ];
});

$factory->afterMaking(Project::class, function ($project, Faker $faker) {
    if (!array_key_exists('owner_id', $project->getAttributes())) {
        $class = $faker->randomElement([Organization::class, User::class]);

        $owner = factory($class)->create();

        $project->fill(['owner_id' => $owner->id, 'owner_type' => $owner->getMorphClass()]);
    }
});
