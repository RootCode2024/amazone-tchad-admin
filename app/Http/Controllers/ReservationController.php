<?php

namespace App\Http\Controllers;

use App\Models\CarLocation;
use App\Models\Client;
use App\Models\Flight;
use App\Models\Hotel;
use Illuminate\Http\Request;
use DateTime;

class ReservationController extends Controller
{
    public function index()
    {
        $flights = Flight::all();
        $hotels = Hotel::all();
        $car_locations = CarLocation::all();
        
        // $flight_hotels = Fligh::all();

        return view('admin.reservations.index', compact('flights', 'hotels', 'car_locations'));
    }

    public function storeFlight(Request $request)
    {        
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20|unique:clients,phone',

            'origin' => 'required|exists:airports,id',
            'destination' => 'required|exists:airports,id',
            'departure' => 'required|date',
            'return' => 'nullable|date',
            'passengers' => 'required|min:1',
            'flight_type' => 'required|in:one-way,round-trip,multi-destination',
            'flight_class' => 'required|in:economy,premium,business',
        ]);
    
        // Enregistrement du client
        $client = Client::firstOrCreate([
            'email' => $request->email,
            'phone' => $request->phone,
        ], [
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'type_of_reservation' => 'flight',
        ]);
    
        // Enregistrement de la réservation
        Flight::create([
            'client_id' => $client->id,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_date' => $request->departure,
            'return_date' => $request->return,
            'passengers' => $request->passengers,
            'status' => 'pending',
            'flight_type' => $request->flight_type,
            'flight_class' => $request->flight_class,
        ]);
        
        return back()->with('success', 'Votre réservation a été enregistrée.');
    }

    public function storeHotel(Request $request)
    {
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20|unique:clients,phone',

            'destination' => 'required|exists:airports,id',
            'arrival_date' => 'required|date',
            'return_date' => 'required|date',
            'number_of_room' => 'required|min:1',
        ]);
    
        // Enregistrement du client
        $client = Client::firstOrCreate([
            'email' => $request->email,
            'phone' => $request->phone,
        ], [
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'type_of_reservation' => 'hotel',
        ]);
    
        // Enregistrement de la réservation
        Hotel::create([
            'client_id' => $client->id,
            'country_id' => $request->destination,
            'arrival_date' => $request->arrival_date,
            'return_date' => $request->return_date,
            'number_of_room' => $request->number_of_room,
            'status' => 'pending',
        ]);
        
        return back()->with('success', 'Votre réservation a été enregistrée.');
    }
 
    public function storeFlightHotel(Request $request)
    {
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20|unique:clients,phone',

            'origin' => 'required|exists:airports,id',
            'destination' => 'required|exists:airports,id',
            'departure' => 'required|date',
            'return' => 'nullable|date',
            'passengers' => 'required|min:1',
            'flight_typeVH' => 'required|in:one-way,round-trip,multi-destination',
            'flight_class' => 'required|in:economy,premium,business',
            'number_of_room' => 'required'
        ]);
    
        // Enregistrement du client
        $client = Client::firstOrCreate([
            'email' => $request->email,
            'phone' => $request->phone,
        ], [
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'type_of_reservation' => 'flight_hotel',
        ]);
    
        // Enregistrement de la réservation du vol
        Flight::create([
            'client_id' => $client->id,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_date' => $request->departure,
            'return_date' => $request->return,
            'passengers' => $request->passengers,
            'status' => 'pending',
            'flight_type' => $request->flight_typeVH,
            'flight_class' => $request->flight_class,
        ]);

        // Enregistrement de la réservation de l'hotel
        Hotel::create([
            'client_id' => $client->id,
            'destination' => $request->destination,
            'arrival_date' => $request->departure,
            'return_date' => $request->return ? $request->return : (new DateTime($request->departure))->modify('+7 days')->format('Y-m-d'),
            'number_of_room' => $request->number_of_room,
            'country_id' => $request->destination,
            'status' => 'pending',
        ]);
        
        return back()->with('success', 'Votre réservation a été enregistrée.');
    }

    public function storeCarLocation(Request $request)
    {
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20|unique:clients,phone',

            'place_of_location' => 'required|exists:airports,id',
            'started_date' => 'required|date',
            'ended_date' => 'required|date',
            'age' => 'required',
        ]);
    
        // Enregistrement du client
        $client = Client::firstOrCreate([
            'email' => $request->email,
            'phone' => $request->phone,
        ], [
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'type_of_reservation' => 'car_location',
        ]);
    
        // Enregistrement de la réservation
        CarLocation::create([
            'client_id' => $client->id,
            'place_of_location' => $request->place_of_location,
            'started_date' => $request->started_date,
            'ended_date' => $request->ended_date,
            'age' => $request->age,
            'status' => 'pending',
        ]);
        
        return back()->with('success', 'Votre réservation a été enregistrée.');
    }
    
    

    public function updateStatusFlight(Request $request, $id)
    {
        $reservation = Flight::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }

    public function updateStatusHotel(Request $request, $id)
    {
        $reservation = Hotel::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }


    public function updateStatusCarLocation(Request $request, $id)
    {
        dd('yo');
        $reservation = CarLocation::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }
}
