<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TrainingsTableSeeder extends Seeder
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
             
                  DB::table('clienttrainings')->insert([
                    'client_id' => $user->id,
                    'subject' => $faker->sentence,
                    'association' => $faker->company,
                    'country' => $faker->country,
                    'training_year' => $faker->year,
            
                     ]);
            }
	  
    }
}