<?php

use Faker\Generator as Faker;

$factory->define(App\Facilitator::class, function (Faker $faker) {
	$users = DB::table('users')->where('role','Facilitator')->get()->toArray();
	$user = $faker->unique()->randomElement($users);
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
		'email' => $user->email,
        'active' => true,
         'gender' => $faker->gender,
        'address' => $faker->address,
         'phone_primary' => $faker->telephone,
        'visible' => true
    ];
});
