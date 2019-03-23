<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->bothify('##??'),
        'description' => $faker->sentence(),
        'private' => $faker->boolean(),
        'created_at'  => now()->subDays($faker->randomDigit(7))->toDateTimeString(),
        'updated_at'  => now()->subDays($faker->randomDigit(7))->toDateTimeString(),
    ];
});
