<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TalentFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'cost' => $this->faker->numberBetween(1, 20),
        ];
    }
}
