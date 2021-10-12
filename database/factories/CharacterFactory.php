<?php

namespace Database\Factories;

use App\Enums\CharacterStatus;
use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Character::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(6),
            'login' => $this->faker->userName(),
            'user_id' => User::factory(),
            'registrar_id' => User::factory(),
            'status' => array_rand(CharacterStatus::getValues())
        ];
    }
}
