<?php

use App\Endpoint;
use Illuminate\Database\Seeder;

class EndpointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $endpoints = factory(Endpoint::class, config('seeds.endpoints.number'))->make()->toArray();

        Endpoint::insert($endpoints);
    }
}
