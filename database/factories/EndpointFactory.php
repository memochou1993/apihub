<?php

use Faker\Generator as Faker;

$factory->define(App\Endpoint::class, function (Faker $faker) {
    return [
        'name' => $faker->bothify('##??'),
        'method' => $faker->randomElement([
            'GET',
            'GET,HEAD',
            'POST',
            'PUT',
            'PATCH',
            'PUT,PATCH',
            'DELETE',
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
        'created_at'  => now()->subDays($faker->randomDigit(7))->toDateTimeString(),
        'updated_at'  => now()->subDays($faker->randomDigit(7))->toDateTimeString(),
    ];
});
