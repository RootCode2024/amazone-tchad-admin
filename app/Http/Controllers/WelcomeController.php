<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    
    public function index()
    {
        $airports = Airport::all();
        
        return view('welcome', compact('airports'));
    }
}
