<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Hotel;
use App\Models\Client;
use App\Models\Flight;
use App\Models\CarLocation;
use Illuminate\Http\Request;
use App\Services\ReservationService;
use App\Mail\SendReservationStatusEmail;


class ReservationController extends Controller
{

    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    
    public function index()
    {
        $flights = Flight::all();
        $hotels = Hotel::all();
        $car_locations = CarLocation::all();

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
    
        $client = $this->reservationService->createClient($request->all(), 'flight');
        $reservation = $this->reservationService->createFlight($client, $request->all());
    
        $this->reservationService->sendReservationEmail($reservation);
    
        return back()->with('success', 'Votre réservation de vol a été enregistrée.');
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
    
        $client = $this->reservationService->createClient($request->all(), 'hotel');
        $reservation = $this->reservationService->createHotel($client, $request->all());
    
        $this->reservationService->sendReservationEmail($reservation);
    
        return back()->with('success', 'Votre réservation d’hôtel a été enregistrée.');
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
            'flight_type' => 'required|in:one-way,round-trip,multi-destination',
            'flight_class' => 'required|in:economy,premium,business',
            'number_of_room' => 'required'
        ]);
    
        $client = $this->reservationService->createClient($request->all(), 'flight_hotel');
        $flight = $this->reservationService->createFlight($client, $request->all());
        $hotel = $this->reservationService->createHotel($client, $request->all());
    
        $this->reservationService->sendReservationEmail($flight);
        $this->reservationService->sendReservationEmail($hotel);
    
        return back()->with('success', 'Votre réservation Vol + Hôtel a été enregistrée.');
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
    
        $client = $this->reservationService->createClient($request->all(), 'car_location');
        $reservation = $this->reservationService->createCarLocation($client, $request->all());
    
        $this->reservationService->sendReservationEmail($reservation);
    
        return back()->with('success', 'Votre réservation de location de voiture a été enregistrée.');
    }
    

    public function updateStatusFlight(Request $request, $id)
    {
        $reservation = Flight::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        SendReservationStatusEmail::dispatch($reservation)->delay(now()->addSeconds(10));

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }

    public function updateStatusHotel(Request $request, $id)
    {
        $reservation = Hotel::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        SendReservationStatusEmail::dispatch($reservation)->delay(now()->addSeconds(10));

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }


    public function updateStatusCarLocation(Request $request, $id)
    {
        $reservation = CarLocation::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();
        
        SendReservationStatusEmail::dispatch($reservation)->delay(now()->addSeconds(10));

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }
}
