<?php

use Faker\Generator as Faker;

$factory->define(App\Endpoint::class, function (Faker $faker) {
    return [
        'method' => $faker->randomElement([
            'GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE',
        ]),
        'name' => $faker->bothify('##??'),
        'description' => $faker->sentence(),
        'project_id' => $faker->numberBetween(1, config('seeds.projects')),
    ];
});
