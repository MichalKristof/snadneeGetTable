<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'restaurant_id' => 1,
            'table_id' => 1,
            'time_from' => date('H:i', strtotime('18:00')),
            'time_to' => date('H:i:s', strtotime('20:00')),
            'date' => date('Y-m-d'),
        ];
    }
}
