<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use Carbon\Carbon;
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

            $tables = Table::where('restaurant_id', $restaurant)->get();
            $openHour = Restaurant::where('id', $request->input('restaurant'))->first()->open_to;

            if ($tables) {
                foreach ($tables as $table) {
                    $reservations = Reservation::where('restaurant_id', $restaurant)
                        ->where('date', $date)
                        ->where('table_id', $table->id)
                        ->orderBy('time_from')
                        ->get();

                    if (count($reservations) > 0) {
                        $table->reservation = $reservations;
                        $tableReserved = $this->isTableReserved($table, $time);

                        if(!$tableReserved){
                            foreach($table->reservation as $reservation) {
                                if(strtotime($reservation->time_from) === strtotime($time) + 3600) {
                                    $table->nextReservation = true;
                                    $table->reserveTimeTo = $reservation->time_from;
                                }
                            }
                        }else{
                            $table->isReserved = $tableReserved;
                        }
                    } else {
                        $table->isReserved = false;
                        if(Carbon::parse($openHour)->greaterThan(Carbon::parse($time)->addHours(2))){
                            $table->reserveTimeTo = Carbon::parse($time)->addHours(2)->format('H:i');
                        }else{
                            $table->reserveTimeTo = $openHour;
                        }

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

    private function isTableReserved($table, $time)
    {
        foreach ($table->reservation as $reservation) {
            if ($time >= $reservation->time_from && $time < $reservation->time_to) {
                return true;
            }
        }
        return false;
    }
}


