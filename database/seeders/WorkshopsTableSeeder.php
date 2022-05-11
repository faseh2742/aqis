<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WorkshopsTableSeeder extends Seeder
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
         $facilitator = DB::table('facilitators')->get()->toArray();
            foreach ($users as $user) 
            {
                # code...
             
                  DB::table('clientworkshops')->insert([
                    'type' => $faker->word,
                    'attendance' =>  $faker->randomDigit,
                    'location' => $faker->city,
                    'client_id' => $user->id,
                    'start_date'=>$faker->date,
                    'end_date'=>$faker->date,
                    'funder' => $faker->company,
                    'facilitator'  =>$faker->randomElement($array = $facilitator)->email,
                    'comments' =>$faker->sentence,
            
                     ]);
            }
	   
    }
}