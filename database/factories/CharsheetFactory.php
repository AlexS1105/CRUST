<?php

namespace Database\Factories;

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
            'skills' => [
                'strength' => $this->faker->numberBetween(0, 12),
                'endurance' => $this->faker->numberBetween(0, 12),
                'perception' => $this->faker->numberBetween(0, 12),
                'agility' => $this->faker->numberBetween(0, 12),
                'determination' => $this->faker->numberBetween(0, 12),
                'erudition' => $this->faker->numberBetween(0, 12),
                'will' => $this->faker->numberBetween(0, 12),
                'potential' => $this->faker->numberBetween(0, 12),
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
                'med' => $this->faker->numberBetween(0, 1),
            ],
        ];
    }
}
