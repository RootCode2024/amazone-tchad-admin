<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'required|string|max:20|unique:clients,telephone',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date',
            'passengers' => 'required|integer|min:1',
        ]);
    
        // Enregistrement du client
        $client = Client::firstOrCreate([
            'email' => $request->email,
            'telephone' => $request->telephone,
        ], [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);
    
        // Enregistrement de la réservation
        Reservation::create([
            'client_id' => $client->id,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'passengers' => $request->passengers,
            'status' => 'pending',
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
