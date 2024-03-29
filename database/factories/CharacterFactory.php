<?php

namespace Database\Factories;

use App\Enums\CharacterGender;
use App\Enums\CharacterStatus;
use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(6),
            'gender' => array_rand(CharacterGender::cases()),
            'race' => $this->faker->word(),
            'age' => $this->faker->numberBetween(1, 100).' '.$this->faker->word(),
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
        ];
    }
}
