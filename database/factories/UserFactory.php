<?php

namespace Database\Factories;

use App\Client;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = User::class;


    public function definition()
    {
        return [
            'firstName'     =>      $this->faker->firstName,
            'lastName'     =>       $this->faker->lastName,
            'username'     =>       $this->faker->unique()->username,
            'email'     =>          $this->faker->unique()->safeEmail,
            'password'     =>       $this->faker->password,
            'role_id'     =>        1,
            'active'     =>         1
        ];
    }
}
