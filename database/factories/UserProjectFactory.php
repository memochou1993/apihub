<?php

use Faker\Generator as Faker;

$factory->define(App\UserProject::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, config('seeds.users')),
        'project_id' => $faker->numberBetween(1, config('seeds.projects')),
    ];
});
