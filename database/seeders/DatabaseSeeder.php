<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Faker\Generator as Faker;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UsersTableSeeder::class);
         $this->call(DropdownTableSeeder::class);
        $this->call(DropdownItemTableSeeder::class);
    }
}
