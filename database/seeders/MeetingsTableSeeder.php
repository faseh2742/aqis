<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
class MeetingsTableSeeder extends Seeder
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
                  DB::table('clientmeetings')->insert([
                    'client_id' => $user->id,
                    'type' =>$faker->word,
                    'date' =>$faker->date,
                    'status' =>$faker->word,
                    'location'=>$faker->city,
                    'funder'=>$faker->company,
                    'facilitator' => $faker->randomElement($array = $facilitator)->email,
                    'comments' =>$faker->sentence,
                    'created_at' =>  Carbon::create(2018, rand(10,11), rand(0,30), 12)->format('Y-m-d H:i:s'),
                   // 'created_at' => Carbon::now()->format('Y-m-d H:i:s'),  
                     ]);
            }
    }
}