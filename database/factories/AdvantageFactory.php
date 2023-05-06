<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdvantageFactory extends Factory
{
    public function definition()
    {
        return [
            'description' => $this->faker->paragraph(),
        ];
    }
}
