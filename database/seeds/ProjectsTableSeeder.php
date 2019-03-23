<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = factory(Project::class, config('seeds.projects.number'))->make()->toArray();

        Project::insert($projects);
    }
}
