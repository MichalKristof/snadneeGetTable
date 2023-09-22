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
}
