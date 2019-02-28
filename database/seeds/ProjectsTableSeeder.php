<?php

use App\Project;
use App\Environment;
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
        /**
         * Create some private projects and environments for the first user.
         */
        factory(Project::class, config('seeds.project:private'))->create([
            'private' => true,
        ])->each(
            function (Project $project) {
                $project->users()->attach(config('seeds.user:first:id'));

                $project->environments()->saveMany(
                    factory(Environment::class, config('seeds.environment'))->make()
                );
            }
        );

        /**
         * Create some private projects and environments for the second user.
         */
        factory(Project::class, config('seeds.project:private'))->create([
            'private' => true,
        ])->each(
            function (Project $project) {
                $project->users()->attach(config('seeds.user:second:id'));

                $project->environments()->saveMany(
                    factory(Environment::class, config('seeds.environment'))->make()
                );
            }
        );

        /**
         * Create some public projects and environments for the other users.
         */
        factory(Project::class, config('seeds.project:public'))->create([
            'private' => false,
        ])->each(
            function (Project $project) {
                $project->environments()->saveMany(
                    factory(Environment::class, config('seeds.environment'))->make()
                );
            }
        );
    }
}
