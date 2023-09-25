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
            'open_from' => date('Y-m-d H:i:s', strtotime('16:00:00')),
            'open_to' => date('Y-m-d H:i:s', strtotime('20:00:00')),
        ];
    }
}
