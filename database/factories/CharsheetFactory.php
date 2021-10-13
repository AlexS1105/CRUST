<?php

namespace Database\Factories;

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
            'character' => Character::factory()->create()->login
        ];
    }
}
