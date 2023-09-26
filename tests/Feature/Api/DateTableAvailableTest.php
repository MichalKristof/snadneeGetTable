<?php

namespace Tests\Feature\Api;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DateTableAvailableTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_returns_tables_and_reservations()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();
        $table1 = Table::factory()->create(['restaurant_id' => $restaurant->id]);
        $table2 = Table::factory()->create(['restaurant_id' => $restaurant->id]);
        $date = '2023-09-30';
        $time = '18:00';

        Reservation::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'table_id' => $table1->id,
            'date' => $date,
            'time_from' => '18:00',
            'time_to' => '19:00',
        ]);

        Reservation::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'table_id' => $table2->id,
            'date' => $date,
            'time_from' => '19:00',
            'time_to' => '20:00',
        ]);

        $response = $this->getJson('/api/find-table', [
            'restaurant' => $restaurant->id,
            'date' => $date,
            'time' => $time,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'code',
                // there will be data
            ]);
    }

    public function test_it_returns_no_tables_for_nonexistent_restaurant()
    {
        $response = $this->getJson('/api/find-table', [
            'restaurant' => 999,
            'date' => '2023-09-30',
            'time' => '18:00',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'code']);
    }
}
