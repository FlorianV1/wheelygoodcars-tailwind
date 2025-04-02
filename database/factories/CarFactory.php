<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'license_plate' => strtoupper(Str::random(2)) . '-' . strtoupper(Str::random(2)) . '-' . rand(10, 99),
            'brand' => $this->faker->company(),
            'model' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 500, 30000),
            'mileage' => $this->faker->numberBetween(0, 250000),
            'seats' => $this->faker->numberBetween(2, 7),
            'doors' => $this->faker->numberBetween(2, 5),
            'production_year' => $this->faker->numberBetween(1995, 2023),
            'weight' => $this->faker->numberBetween(800, 2500),
            'color' => $this->faker->safeColorName(),
        ];
    }
}
