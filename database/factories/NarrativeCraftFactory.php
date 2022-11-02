<?php

namespace Database\Factories;

use App\Models\NarrativeCraft;
use Illuminate\Database\Eloquent\Factories\Factory;

class NarrativeCraftFactory extends Factory
{
    protected $model = NarrativeCraft::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
        ];
    }
}
