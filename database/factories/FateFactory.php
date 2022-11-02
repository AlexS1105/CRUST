<?php

namespace Database\Factories;

use App\Enums\FateType;
use App\Models\Fate;
use Illuminate\Database\Eloquent\Factories\Factory;

class FateFactory extends Factory
{
    protected $model = Fate::class;

    public function definition()
    {
        return [
            'text' => $this->faker->paragraph(),
            'type' => $this->faker->numberBetween(0, pow(2, count(FateType::cases()))),
        ];
    }
}
