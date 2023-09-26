<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    public function test_show_reservations_not_logged_in(): void
    {
        $response = $this
            ->get(route('reservation.reservations'));

        $response->assertRedirect('/login');
    }

    public function test_show_reservations_logged_in(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('reservation.reservations'));

        $response->assertViewIs('reservation.reservations');
        $response->assertViewHas('reservations');
    }

    public function test_cancel_reservation(): void
    {
        $user = User::factory()->create();

        $restaurant = Restaurant::factory()->create();

        $table = Table::factory()->create([
            'restaurant_id' => $restaurant->id,
        ]);

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'table_id' => $table->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('reservation.cancelReservation', ['id' => $reservation->id]));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertNull($reservation->fresh());
    }
}
