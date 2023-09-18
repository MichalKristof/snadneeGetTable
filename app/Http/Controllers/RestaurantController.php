<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function index() : View
    {
        $restaurants = Restaurant::all();

        return view('restaurant.index', compact('restaurants'));
    }

    public function tables($slug) : View
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        $restaurant_id = $restaurant->id;
        $open_from = $restaurant->getOpenFromTime();
        $open_to = $restaurant->getOpenToTime();

        $tables = Table::with('restaurant')->where('restaurant_id', $restaurant_id)->get();

        return view('table.index', compact('tables', 'open_from', 'open_to', 'restaurant_id'));
    }
}
