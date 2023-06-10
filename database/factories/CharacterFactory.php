<?php

namespace Database\Factories;

use App\Enums\CharacterOrigin;
use App\Enums\CharacterStatus;
use App\Enums\CharacterTitle;
use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(6),
            'origin' => array_rand(CharacterOrigin::cases()),
            'race' => $this->faker->word(),
            'age' => $this->faker->numberBetween(1, 100).' '.$this->faker->word(),
            'legacy' => $this->faker->words(3, true),
            'appearance' => $this->faker->paragraph(10),
            'background' => $this->faker->paragraphs(100, true),
            'login' => $this->faker->userName(),
            'info_hidden' => $this->faker->boolean(),
            'bio_hidden' => $this->faker->boolean(),
            'status' => CharacterStatus::from(array_rand(CharacterStatus::cases())),
            'status_updated_at' => now(),
            'personality' => $this->faker->paragraph(),
            'player_only_info' => $this->faker->paragraph(),
            'gm_only_info' => $this->faker->paragraph(),
            'estitence' => $this->faker->numberBetween(20, 100),
            'perk_points' => $this->faker->numberBetween(24, 36),
            'skill_points' => $this->faker->numberBetween(16, 32),
            'talent_points' => $this->faker->numberBetween(12, 42),
            'experience' => $this->faker->numberBetween(0, 20),
            'technique_points' => $this->faker->numberBetween(5, 35),
            'title' => CharacterTitle::from(array_rand(CharacterTitle::cases())),
        ];
    }
}
