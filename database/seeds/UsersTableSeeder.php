<?php

use App\User;
use App\Project;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create the first user.
         */
        User::create([
            'username' => 'first',
            'name' => 'First User',
            'email' => 'first@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);

        /**
         * Create the second user.
         */
        User::create([
            'username' => 'second',
            'name' => 'Second User',
            'email' => 'second@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);

        /**
         * Create the other users.
         */
        factory(User::class, config('seeds.user'))->create();
    }
}
