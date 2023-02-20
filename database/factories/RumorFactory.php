<?php

namespace Database\Factories;

use App\Enums\Tide;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RumorFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'text' => $this->faker->sentence(),
            'tide' => $this->faker->randomElement(array_map(fn ($tide) => $tide->value, Tide::cases())),
        ];
    }
}
