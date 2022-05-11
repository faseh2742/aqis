<?php

namespace Database\Factories;

use App\Client;
use App\Clientemployment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientEmploymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = Clientemployment::class;


    public function definition()
    {
        return [
            'client_id'         =>      Client::factory(),
            'noc'               =>      $this->faker->randomNumber(4, true),
            'job_title'         =>      $this->faker->jobTitle,
            'experience_years'  =>      $this->faker->randomDigit,
            'country'           =>      $this->faker->country,
        ];
    }
}
