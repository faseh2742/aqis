<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FacilitatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
       $faker = Faker::create();
       $users = DB::table('users')->where('role_id','2')->get();
            foreach ($users as $user) 
            {
                  DB::table('facilitators')->insert([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'email' => $user->email,
                    'active' => true,
                    'gender' => $faker->title,
                    'address' => $faker->address,
                    'phone_primary' => $faker->phoneNumber,
                    'visible' => true
                     ]);
            }
    
    }
}
