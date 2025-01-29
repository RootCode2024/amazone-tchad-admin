<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;
use DateTime;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        return view('admin.reservations.index', compact('reservations'));
    }
    
    public function store(Request $request)
    {
        // Valider les données de la requête avec les dates converties
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'required|string|max:20|unique:clients,telephone',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure' => 'required',
            'return' => 'nullable',
            'passengers' => 'required|min:1',
            'type' => 'required|in:one-way,round-trip,multi-destination',
            'flight_class' => 'required|in:economy,premium,business',
        ]);
    
        // Enregistrement du client
        $client = Client::firstOrCreate([
            'email' => $request->email,
            'phone' => $request->telephone,
        ], [
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
        ]);
    
        // Enregistrement de la réservation
        Reservation::create([
            'client_id' => $client->id,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_date' => $request->departure,
            'return_date' => $request->return,
            'passengers' => $request->passengers,
            'status' => 'pending',
            'type' => $request->type,
            'flight_class' => $request->flight_class,
        ]);
    
        return back()->with('success', 'Votre réservation a été enregistrée.');
    }
    
    

    public function validateReservation(Reservation $reservation)
    {
        $reservation->update(['status' => 'validated']);
        return back()->with('success', 'La réservation a été validée.');
    }

    public function rejectReservation(Reservation $reservation)
    {
        $reservation->update(['status' => 'rejected']);
        return back()->with('error', 'La réservation a été rejetée.');
    }
}
