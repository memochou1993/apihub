<?php

use App\Environment;
use Illuminate\Database\Seeder;

class EnvironmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $environments = factory(Environment::class, config('seeds.environments.number'))->make()->toArray();

        Environment::insert($environments);
    }
}
