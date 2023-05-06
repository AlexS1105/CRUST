<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TechniqueFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
