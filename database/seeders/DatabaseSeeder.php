<?php

namespace Database\Seeders;

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
        $this->call(UsersTableSeeders::class);
        $this->call(BookableTableSeeder::class);
        $this->call(BookingsTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
    }
}
