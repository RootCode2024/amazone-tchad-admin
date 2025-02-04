<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CarLocation;
use App\Models\Client;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::count();

        $clients = Client::count();

        $flights = Flight::where('status', 'validated')->count();
        $hotels = Hotel::where('status', 'validated')->count();
        $carLocations = CarLocation::where('status', 'validated')->count();
        
        $flightsPendding = Flight::where('status', 'pending')->count();
        $hotelsPendding = Hotel::where('status', 'pending')->count();
        $carLocationsPendding = CarLocation::where('status', 'pending')->count();
       
        $reservations = $carLocations + $flights + $hotels;
        $reservationsPendding = $carLocationsPendding + $flightsPendding + $hotelsPendding;

        return view('backend.dashboard', compact('users', 'clients', 'reservations', 'reservationsPendding'));
    }

    public function users()
    {
        $users = User::all();

        return view('backend.users.index', compact('users'));
    }

}
