<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function reservations() : View
    {
        $reservations = Reservation::with('table','restaurant', 'user')->where('user_id', Auth::user()->id)->orderBy('created_at','desc')->get();

        return view('reservation.reservations', compact('reservations'));
    }

    public function cancelReservation($id) : RedirectResponse
    {
        $reservation = Reservation::find($id);
        $reservation->delete();

        session()->flash('success', 'Reservation has been successfully canceled.');

        return Redirect::back();
    }
}
