<?php

namespace Database\Factories;

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
function RoleGenerator()
{
    $x = rand(1, 3);
    switch ($x) {
        case 1:
            return 'Client';

        case 2:
            return 'Facilitator';

        case 3:
            return 'Admin';

        default:
            return 'Bugged';

    }
}

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('secret'), // secret
        'remember_token' => Str::random(10),
//        'role' => RoleGenerator()
        'role_id' => 1,
        'active' => 1
    ];
});
