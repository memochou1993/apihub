<?php

use Faker\Generator as Faker;

$factory->define(App\Environment::class, function (Faker $faker) {
    return [
        'name' => $faker->bothify('##??'),
        'description' => $faker->sentence(),
        'variable' => json_encode([
            'API_KEY' => '$2y$10$7lYuU08DeN1tsZJdNHBl4OaF4mWpezqQxSE7HalIgi9xQ/5JTwYfS', // key
            'API_SECRET' => '$2y$10$cHyBqkRdoSzWRQ0uZ.sXNesMxg/Qr/Cbb9o2nFrpBun7NrAr.zHQG', // secret
        ]),
        'project_id' => $faker->numberBetween(1, config('seeds.projects.number')),
        'created_at'  => now()->toDateTimeString(),
        'updated_at'  => now()->toDateTimeString(),
    ];
});
