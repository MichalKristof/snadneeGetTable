<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $requestedTime = $request->input('time');
            $requestedTimeHour = Carbon::parse($requestedTime)->addHour()->format('H:i');
            $date = $request->input('date');

            $activeReservation = Reservation::where('restaurant_id', $request->input('restaurant'))
                ->where('date', $date)
                ->where('table_id', $request->input('table'))
                ->where(function ($query) use ($requestedTimeHour) {
                    $query->where('time_from', '<=', $requestedTimeHour)
                        ->where('time_to', '>=', $requestedTimeHour);
                })
                ->first();

            $reservation = new Reservation();
            $reservation->user_id = $request->input('user');
            $reservation->restaurant_id = $request->input('restaurant');
            $reservation->table_id = $request->input('table');
            $reservation->time_from = $requestedTime;
            if ($activeReservation !== null) {
                $reservation->time_to = $activeReservation->time_from;
            } else {
                $openHour = Restaurant::where('id', $request->input('restaurant'))->first()->open_to;
                $requestedTimeTwoHours = Carbon::parse($requestedTime)->addHours(2);

                if ($requestedTimeTwoHours->greaterThan(Carbon::parse($openHour))) {
                    $reservation->time_to = $openHour;
                } else {
                    $reservation->time_to = $requestedTimeTwoHours->format('H:i');
                }
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
