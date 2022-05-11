<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmploymentsTableSeeder extends Seeder
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
               
                  DB::table('clientemployments')->insert([
                   
                      'noc' => random_int('1111', '6666'),
                    'job_title' => $faker->jobTitle,
                    'field' => $faker->word,
                    'client_id' => $user->id,
                     'experience_years' => random_int('0','20'),
                     'country' => $faker->country,
                     ]);
            }
    }
}