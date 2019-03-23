<?php

use Faker\Generator as Faker;

$factory->define(App\Endpoint::class, function (Faker $faker) {
    return [
        'name' => $faker->bothify('##??'),
        'method' => $faker->randomElement([
            'GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE',
        ]),
        'uri' => 'api/'.$faker->randomElement([
            'users/{user}',
            'projects/{project}',
            'environments/{environment}',
            'endpoints/{endpoint}',
            'calls/{call}',
        ]),
        'description' => $faker->sentence(),
        'project_id' => $faker->numberBetween(1, config('seeds.projects.number')),
    ];
});
