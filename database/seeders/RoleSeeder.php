<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //   $faker = Faker::create();
        DB::table('roles')->insert([
            'role' => 'Client'
        ]);
        DB::table('roles')->insert([
            'role' => 'Facilitator'
        ]);
        DB::table('roles')->insert([
            'role' => 'Admin',
        ]);
    }
}
  