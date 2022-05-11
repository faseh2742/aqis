<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class clientapsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $faker = Faker::create();
         $users = DB::table('clients')->get()->toArray();
         $facilitator = DB::table('facilitators')->get()->toArray();
         for ($i = 0 ; $i <= 30; $i++)
	    DB::table('clientaps')->insert([
	    	'client_id' => $faker->randomElement($array = $users)->client_id,
	    	'facilitator' => $faker->randomElement($array = $facilitator)->email,
            'noc' => random_int('1111', '6666'),
            'category' => $faker->jobTitle,
            'cert_license' => $faker->word,
            'credential_eval' => str_random(20),
            'docs_trans' => $faker->sentence,
            'training' => $faker->jobTitle,
            'bridging' => $faker->company,
            'language' => $faker->country,
            'further_education' =>"Bachelors",
            'trades' => $faker->jobTitle,
            'workplace_exp' => $faker->company,
            'alt_career' => $faker->jobTitle,
            'mentoring'=> $faker->name,
        ]);
    }
}
