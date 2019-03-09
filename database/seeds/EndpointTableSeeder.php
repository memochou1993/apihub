<?php

use App\Endpoint;
use Illuminate\Database\Seeder;

class EndpointTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Endpoint::class, config('seeds.endpoints'))->create();
    }
}
