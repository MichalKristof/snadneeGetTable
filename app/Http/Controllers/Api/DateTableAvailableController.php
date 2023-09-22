<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DateTableAvailableController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $restaurant = $request->input('restaurant');
            $time = $request->input('time');
            $date = $request->input('date');

            $tables = Table::where('restaurant_id', $restaurant)->where('reserved', false)->get();

            if($tables){
                foreach ($tables as $table) {
                    $reservations = Reservation::where('restaurant_id', $restaurant)
                        ->where('date', $date)
                        ->where('table_id', $table->id)
                        ->where(function ($query) use ($time) {
                            $query->where('time_from', '<=', $time)
                                ->where('time_to', '>=', $time);
                        })
                        ->get();

                    if(count($reservations) > 0) {
                        $table->reservation = $reservations;
                    }
                }

                return response()->json([
                    'message' => 'Tables found',
                    'code' => 200,
                    'data' => $tables,
                ]);
            }

            return response()->json([
                'message' => "No tables found for this restaurant",
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
