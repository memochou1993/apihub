<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->bothify('Project ##??'),
        'description' => $faker->sentence(),
        'private' => $faker->boolean(),
    ];
});
