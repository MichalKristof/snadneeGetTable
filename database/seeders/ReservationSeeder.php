<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservation::factory(1)->create();
        Reservation::create(
            [
                'user_id' => 1,
                'restaurant_id' => 1,
                'table_id' => 1,
                'time_from' => date('H:i', strtotime('20:00')),
                'time_to' => date('H:i:s', strtotime('22:00')),
                'date' => date('Y-m-d'),
            ]
        );
    }
}
