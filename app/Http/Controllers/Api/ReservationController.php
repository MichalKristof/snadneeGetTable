<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $reservation = new Reservation();
            $reservation->user_id = 1;
            $reservation->restaurant_id = $request->input('restaurant');
            $reservation->table_id = $request->input('table');
            $reservation->time_from = implode(':', $request->input('time_from'));
            $reservation->time_to = implode(':', $request->input('time_to'));
            $reservation->date = $request->input('date');
            $reservation->save();

            return response()->json([
                'message' => "No reservation found for this date and table",
                'code' => 204,
                'data' => $request->all(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Request failed",
                'code' => 404,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
