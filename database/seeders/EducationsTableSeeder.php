<?php

use Illuminate\Database\Seeder;
use App\Client;
use Faker\Factory as Faker;

class EducationsTableSeeder extends Seeder
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
               
                  DB::table('clienteducations')->insert([
                   
                    'client_id' => $user->id,
                     'major' => $faker->company,
                     'education_country' => $faker->country,
                    'education_level' => "Bachelors",
                    'graduation_date' => $faker->creditCardExpirationDate
                    
                     ]);
            }


    }
}
