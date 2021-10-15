<?php

namespace Database\Factories;

use App\Enums\CharacterStatus;
use App\Models\Charsheet;
use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharsheetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Charsheet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'character' => Character::factory()->create(['status' => CharacterStatus::Pending()])->login,
            'special_stats' => [
                'points' => $this->faker->randomNumber(2)
            ],
            'approaches' => [
                'careful' => $this->faker->numberBetween(1, 4),
                'clever' => $this->faker->numberBetween(1, 4),
                'flashy' => $this->faker->numberBetween(1, 4),
                'forceful' => $this->faker->numberBetween(1, 4),
                'quick' => $this->faker->numberBetween(1, 4),
                'sneaky' => $this->faker->numberBetween(1, 4)
            ],
            'crafts' => [
                'arc' => $this->faker->numberBetween(0, 3),
                'mys' => $this->faker->numberBetween(0, 3),
                'enc' => $this->faker->numberBetween(0, 3),
                'alc' => $this->faker->numberBetween(0, 3),
                'eng' => $this->faker->numberBetween(0, 3),
                'mnf' => $this->faker->numberBetween(0, 3),
                'inf' => $this->faker->numberBetween(0, 3),
                'chm' => $this->faker->numberBetween(0, 3),
                'smt' => $this->faker->numberBetween(0, 3),
            ],
        ];
    }
}
