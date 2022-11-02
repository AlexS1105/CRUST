<?php

namespace Database\Factories;

use App\Models\Sphere;
use Illuminate\Database\Eloquent\Factories\Factory;

class SphereFactory extends Factory
{
    protected $model = Sphere::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'value' => $this->faker->numberBetween(0, 10),
        ];
    }
}
