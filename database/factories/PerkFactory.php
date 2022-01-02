<?php

namespace Database\Factories;

use App\Models\Perk;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Perk::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'cost' => $this->faker->numberBetween(1, 20)
        ];
    }
}
