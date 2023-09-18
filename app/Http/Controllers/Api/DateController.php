<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $date = $request->input('date');
            $table = $request->input('table');
            $reservationExists = Reservation::where('id', $table)->where('date', $date)->exists();


            if($reservationExists) {
                $reservation = Reservation::where('id', $table)->where('date', $date)->firstOrFail();

                return response()->json([
                    'message' => 'Reservation found',
                    'code' => 200,
                    'data' => $reservation->getTimeFrom(),
                ]);
            }

            return response()->json([
                'message' => "No reservation found for this date and table",
                'code' => 204,
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
