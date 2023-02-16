<?php

namespace Database\Factories;

use App\Enums\CharacterStat;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition()
    {
        return [
            'proficiency' => $this->faker->boolean(),
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'stat' => CharacterStat::cases()[array_rand(CharacterStat::cases())],
        ];
    }
}
