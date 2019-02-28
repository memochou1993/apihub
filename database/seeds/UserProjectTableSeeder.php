<?php

use App\User;
use App\Project;
use Illuminate\Database\Seeder;

class UserProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get all public projects.
         */
        $projects = Project::where('private', false)->get();

        /**
         * Create many-to-many relationships between users and public projects.
         */
        User::all()->each(function ($user) use ($projects) { 
            $user->projects()->attach(
                $projects->random(rand(1, config('seeds.user')))->pluck('id')->all()
            ); 
        });
    }
}
