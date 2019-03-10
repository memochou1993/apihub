<?php

use Faker\Generator as Faker;

$factory->define(App\Call::class, function (Faker $faker) {
    return [
        'request' => json_encode([
            'headers' => [
                'Accept' => 'application/json'
            ],
            'body' => [],
        ]),
        'response' => json_encode([
            'status' => $faker->randomElement([
                200, 201, 204, 401, 403,
            ]),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => [],
        ]),
        'endpoint_id' => $faker->numberBetween(1, config('seeds.endpoints.number')),
    ];
});
