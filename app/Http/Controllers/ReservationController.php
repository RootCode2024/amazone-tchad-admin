<?php

namespace App\Http\Controllers;

use App\Mail\SendReservationStatusEmail;
use App\Models\CarLocation;
use App\Models\Client;
use App\Models\Flight;
use App\Models\Hotel;
use App\Services\ReservationService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'origin' => 'required|exists:airports,id',
            'destination' => 'required|exists:airports,id',
            'departure' => 'required|date',
            'return' => 'nullable|date',
            'passengers' => 'required|min:1',
            'flight_type' => 'required|in:one-way,round-trip,multi-destination',
            'flight_class' => 'required|in:economy,premium,business',
        ]);

        
        $client = Client::where('email', $request->email)->first();
        if (!$client) {
            $client = $this->reservationService->createClient($request->all(), 'flight');
        }else
        {
            $client->type_of_reservation = 'flight';
            $client->save();            
        }
        
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
        
        $this->reservationService->sendReservationStatusChange($reservation);

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }

    public function updateStatusHotel(Request $request, $id)
    {
        $reservation = Hotel::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        $this->reservationService->sendReservationStatusChange($reservation);

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }


    public function updateStatusCarLocation(Request $request, $id)
    {
        $reservation = CarLocation::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();
        
        $this->reservationService->sendReservationStatusChange($reservation);

        return response()->json(['success' => true, 'newStatus' => $reservation->status]);
    }


    public function updateRejected(Request $request, $id, $type)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'finded_price' => 'required|numeric',
                'finded_departure_date' => 'required|date',
                'finded_return_date' => 'nullable|date',
                'notes' => 'nullable|string', // notes est optionnel
            ]);

            // Trouver la réservation existante par ID
            if($type == 'flight')
            {
                $reservation = Flight::find($id);

                // Mise à jour des champs
                $reservation->finded_departure_date = $validatedData['finded_departure_date'];
                $reservation->finded_return_date = $validatedData['finded_return_date'];

            }elseif($type == 'hotel')
            {
                $reservation = Hotel::find($id);

                // Mise à jour des champs
                $reservation->finded_arrival_date = $validatedData['finded_departure_date'];
                $reservation->finded_return_date = $validatedData['finded_return_date'];
                
            }else
            {
                $reservation = CarLocation::find($id);

                // Mise à jour des champs
                $reservation->finded_started_date = $validatedData['finded_departure_date'];
                $reservation->finded_ended_date = $validatedData['finded_return_date'];
            }

            

            $reservation->finded_price = $validatedData['finded_price'];
            $reservation->notes = $validatedData['notes'];
            $reservation->status = 'rejected';

            // Sauvegarde des modifications
            $reservation->save();

            // Retourner une réponse de succès
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // En cas d'erreur, loguer et retourner une erreur
            Log::error('Erreur lors de la mise à jour de la réservation rejetée: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updateValidated($id, $type, Request $request) {
        
        
        if($type == 'flight')
        {
            $reservation = Flight::find($id);
        }elseif($type == 'hotel')
        {
            $reservation = Hotel::find($id);
        }else
        {
            $reservation = CarLocation::find($id);
        }
    
        if (!$reservation) {
            return response()->json(['error' => 'Réservation non trouvée.'], 404);
        }
    
        // Mettre à jour les champs de la réservation
        $reservation->finded_price = $request->finded_price;
        $reservation->notes = $request->notes;
        $reservation->status = 'validated';
    
        $reservation->save();
    
        return response()->json(['success' => 'Réservation validée avec succès.']);
    }
    
    public function updatePending($id, $type, Request $request)
    {

        if($type == 'flight')
        {
            $reservation = Flight::find($id);
        }elseif($type == 'hotel')
        {
            $reservation = Hotel::find($id);
        }else
        {
            $reservation = CarLocation::find($id);
        }
    
        if (!$reservation) {
            return response()->json(['error' => 'Réservation non trouvée.'], 404);
        }
    
        // Mettre à jour le statut de la réservation
        $reservation->status = $request->status;
    
        $reservation->save();
    
        return response()->json(['success' => 'Statut de la réservation mis à jour.']);
    }
}
