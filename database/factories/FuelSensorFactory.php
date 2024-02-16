<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FuelSensor>
 */
class FuelSensorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model'=>fake()->word,
            'serial_number'=>fake()->randomNumber(9),
            'vehicle_id'=>fake()->numberBetween(1,500),
        ];
    }
}
