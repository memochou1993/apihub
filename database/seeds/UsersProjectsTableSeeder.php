<?php

use App\UserProject;
use Illuminate\Database\Seeder;

class UsersProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserProject::class, config('seeds.users_projects'))->create();
    }
}
