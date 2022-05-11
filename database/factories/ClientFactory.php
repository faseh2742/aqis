<?php

namespace Database\Factories;

use App\Clienteducation;
use App\User;
use App\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{

    protected $model = Client::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'           =>  User::factory(),
            'wc_id'             =>  $this->faker->unique()->randomNumber(5, true),
            'immigrationStatus' =>  $this->faker->word,
            'dob'               =>  $this->faker->date('Y-m-d'),
            'doa'               =>  $this->faker->date('Y-m-d'),
            'gender'            =>  $this->faker->randomElement(array('Male','Female','Other')),
            'streetAddress'     =>  $this->faker->streetAddress,
            'phonePrimary'     =>  $this->faker->e164PhoneNumber,
            'phoneSecondary'     =>  $this->faker->e164PhoneNumber,
        ];
    }
}
