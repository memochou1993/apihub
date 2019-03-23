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
        $users_projects = factory(UserProject::class, config('seeds.users_projects.number'))->make()->unique(function ($item) {
            return $item['user_id'].'-'.$item['project_id'];
        })->toArray();

        UserProject::insert($users_projects);
    }
}
