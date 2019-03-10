<?php

use Faker\Generator as Faker;

$factory->define(App\UserProject::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, config('seeds.users.number')),
        'project_id' => $faker->numberBetween(1, config('seeds.projects.number')),
    ];
});
