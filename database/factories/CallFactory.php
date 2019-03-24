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
                200, 201, 204,
            ]),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => [],
        ]),
        'endpoint_id' => $faker->numberBetween(1, config('seeds.endpoints.number')),
        'created_at'  => now()->subDays($faker->randomDigit(7))->toDateTimeString(),
        'updated_at'  => now()->subDays($faker->randomDigit(7))->toDateTimeString(),
    ];
});
