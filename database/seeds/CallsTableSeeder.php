<?php

use App\Call;
use Illuminate\Database\Seeder;

class CallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Call::class, config('seeds.calls.number'))->create();
    }
}
