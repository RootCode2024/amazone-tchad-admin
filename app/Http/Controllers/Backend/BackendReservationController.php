<?php

namespace App\Http\Controllers\Backend;

use Route;
use App\Models\Hotel;
use App\Models\Client;
use App\Models\Flight;
use App\Models\CarLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackendReservationController extends Controller
{
    /**
     * Affiche la liste des reservation (Page Blade)
     */
    public function index()
    {
        return view('backend.clients.reservations');
    }

    public function clientDetails($id)
    {
        $client = Client::find($id);
    
        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client introuvable'
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $client->id,
                'name' => $client->firstname . ' ' . $client->lastname,
                'phone' => $client->phone,
                'email' => $client->email ?? 'Non renseigné'
            ]
        ], 200);
    }
    

    public function show($client_id, $reservation_id)
    {
        // Recherche d'une réservation parmi les différentes tables
        $reservation = Flight::where('client_id', $client_id)->with(['country', 'destination'])->find($reservation_id) 
                    ?? Hotel::where('client_id', $client_id)->find($reservation_id) 
                    ?? CarLocation::where('client_id', $client_id)->find($reservation_id);
    
        if (!$reservation) {
            return redirect()->route('clients.index')->with('error', 'Réservation non trouvée.');
        }
    
        // Déterminer le type de réservation
        $type = match(true) {
            $reservation instanceof Flight => 'Vol',
            $reservation instanceof Hotel => 'Hôtel',
            $reservation instanceof CarLocation => 'Location de Voiture',
            default => 'Inconnu'
        };    
    
        return view('backend.clients.detailsreservation', compact('reservation', 'type'));
    }
    

    public function fetchReservations(Request $request)
    {
        // Récupération du nom de la route actuelle
        $routeName = Route::currentRouteName();
    
        // Déterminez quelle méthode appeler en fonction du nom de la route
        if ($routeName === 'reservations.fetchVols') {
            $results = $this->fetchFlights($request);
        } elseif ($routeName === 'reservations.fetchHotels') {
            $results = $this->fetchHotels($request);
        } elseif ($routeName === 'reservations.fetchVolsHotels') {
            $results = $this->fetchVolsHotels($request);
        } elseif ($routeName === 'reservations.fetchLocations') {
            $results = $this->fetchLocations($request);
        } else {
            $results = [];
        }
    
        return response()->json($results);
    }  


    //HOTELS

    public function fetchHotels(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $currentPage = $request->get('page', 1);
        
        $hotels = Hotel::with(['client', 'country'])
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage, ['*'], 'page', $currentPage);

        return $hotels;
    }

    /**
     * Supprime un client
     */
    public function destroyHotel($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return response()->json(['message' => 'Réservation Hotel supprimé avec succès']);
    }

    //VOLS

    /**
     * Récupère les clients qui ont reservés un vol en JSON pour l'affichage dynamique
     */
    public function fetchFlights(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $currentPage = $request->get('page', 1);
    
        $flights = Flight::with(['client', 'countries', 'destinations'])
                                ->orderBy('created_at', 'desc')
                                ->paginate($perPage, ['*'], 'page', $currentPage);
    
        return $flights;
    }

    /**
     * Supprime un vol
     */
    public function destroyVol($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();

        return response()->json(['message' => 'Réservation Vol supprimé avec succès']);
    }

    
    //LOCATION DE VOITURE

    /**
     * Récupère les clients qui ont reservés une voiture en JSON pour l'affichage dynamique
     */
    public function fetchLocations(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $currentPage = $request->get('page', 1);
    
        $location = CarLocation::with(['client', 'country'])
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage, ['*'], 'page', $currentPage);
    
        return $location;
    }

    /**
     * Supprime une Reservation de voiture
     */
    public function destroyCar($id)
    {
        $car = CarLocation::findOrFail($id);
        $car->delete();

        return response()->json(['message' => 'Réservation de voiture supprimé avec succès']);
    }
}
