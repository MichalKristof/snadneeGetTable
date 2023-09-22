<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $requestedTime = $request->input('time');

            $activeReservation = Reservation::where('restaurant_id', $request->input('restaurant'))
                ->where('date', $request->input('date'))
                ->where('table_id', $request->input('table'))
                ->where(function ($query) use ($requestedTime) {
                    $query->where('time_from', '<=', $requestedTime)
                        ->orWhere('time_from', '>=', $requestedTime);
                })
                ->get();

            $reservation = new Reservation();
            $reservation->user_id = $request->input('user');
            $reservation->restaurant_id = $request->input('restaurant');
            $reservation->table_id = $request->input('table');
            $reservation->time_from = $requestedTime;
            if ($activeReservation->isEmpty()) {
                $reservation->time_to = Carbon::parse($requestedTime)->addHours(2)->format('H:i');
            } else {
                $reservation->time_to = $activeReservation->time_from;
            }
            $reservation->date = $request->input('date');
            $reservation->save();

            return response()->json([
                'message' => "Reservation successful",
                'code' => 200,
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
