<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Charsheet;
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
            'character' => Character::factory()->create(['registrar_id' => null])->login,
            'skills' => [
                'fitness'       => $this->faker->numberBetween(0, 10),
                'perception'    => $this->faker->numberBetween(0, 10),
                'agility'       => $this->faker->numberBetween(0, 10),
                'coordination'  => $this->faker->numberBetween(0, 10),
                'ingenuity'     => $this->faker->numberBetween(0, 10),
                'tech'          => $this->faker->numberBetween(0, 10),
                'magic'         => $this->faker->numberBetween(0, 10),
                'charisma'      => $this->faker->numberBetween(0, 10),
                'composure'     => $this->faker->numberBetween(0, 10)
            ],
            'crafts' => [
                'arc' => $this->faker->numberBetween(0, 3),
                'mys' => $this->faker->numberBetween(0, 2),
                'wiz' => $this->faker->numberBetween(0, 2),
                'mnf' => $this->faker->numberBetween(0, 3),
                'eng' => $this->faker->numberBetween(0, 2),
                'gun' => $this->faker->numberBetween(0, 2),
                'chm' => $this->faker->numberBetween(0, 2),
                'smt' => $this->faker->numberBetween(0, 2),
                'bld' => $this->faker->numberBetween(0, 1),
                'med' => $this->faker->numberBetween(0, 1)
            ]
        ];
    }
}
