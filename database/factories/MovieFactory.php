<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($this->faker->numberBetween(1,3)),
            'director' => $this->faker->name(),
            'description' => $this->faker->paragraphs($this->faker->numberBetween(1,3), true),
            'year'  => $this->faker->year(),
            'length' => $this->faker->randomNumber(5)
        ];
    }
}
