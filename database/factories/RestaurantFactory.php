<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'capacity' => $this->faker->numberBetween(3, 10),
            'open_from' => date('H:i:s', strtotime('16:00:00')),
            'open_to' => date('H:i:s', strtotime('23:00:00')),
        ];
    }
}
