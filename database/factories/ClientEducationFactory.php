<?php

namespace Database\Factories;

use App\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientEducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id'         =>      Client::factory(),
            'education_level'   =>      $this->faker->word,
            'major'             =>      $this->faker->word,
            'graduation_date'   =>      $this->faker->date('Y-m-d'),
            'education_country'   =>      $this->faker->country,
        ];
    }
}
