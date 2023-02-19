<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TideFactory extends Factory
{
    public function definition()
    {
        return [
            'level' => $this->faker->numberBetween(0, 10),
            'path' => $this->faker->sentence(),
        ];
    }
}
