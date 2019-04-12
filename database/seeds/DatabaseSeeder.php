<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LinksTableSeeder::class);
        $this->call(RepliesTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
