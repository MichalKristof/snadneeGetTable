<?php

namespace Tests\Feature\Api;

use App\Http\Controllers\Api\ReservationController;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_can_make_a_reservation()
    {
        $restaurant = Restaurant::factory()->create();
        $table = Table::factory()->create(['restaurant_id' => $restaurant->id]);
        $user = User::factory()->create();
        $date = '2023-09-30';
        $time = '18:00';

        $request = new Request([
            'restaurant' => $restaurant->id,
            'table' => $table->id,
            'user' => $user->id,
            'date' => $date,
            'time' => $time,
        ]);

        $controller = new ReservationController();

        $response = $controller->index($request);

        $response->assertJson([
            'message' => 'Reservation successful',
            'code' => 200,
        ]);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'table_id' => $table->id,
            'date' => $date,
            'time_from' => $time,
        ]);
    }

    public function test_it_handles_failed_reservation_request()
    {
        $request = new Request([
        ]);

        $controller = new ReservationController();

        $response = $controller->index($request);

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'code',
                'error',
            ]);

        $this->assertDatabaseCount('reservations', 0);
    }
}

