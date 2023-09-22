<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index($slug) : View
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();

        $openFrom = Carbon::parse($restaurant->open_from);
        $openTo = Carbon::parse($restaurant->open_to);
        $interval = CarbonInterval::hour(1);

        $times = [];

        while ($openFrom < $openTo) {
            $times[] = $openFrom->format('H:i');
            $openFrom = $openFrom->add($interval);
        }

        return view('reservation.index', compact('restaurant','times'));
    }

    public function show() : View
    {
        dd('cauko');
    }
}
