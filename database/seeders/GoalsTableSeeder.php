<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
         $users = DB::table('clients')->get();
            foreach ($users as $user) 
            {
                # code...
             
                  DB::table('clientgoals')->insert([
                    'client_id' => $user->id,
                     'employment_goals' => $faker->realText,
                     'meeting_expectation' => $faker->realText,
                     
                     ]);
            }
	   
    }
}