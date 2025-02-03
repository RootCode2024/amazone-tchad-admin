<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Client;
use App\Models\Flight;
use App\Models\CarLocation;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Affiche la liste des clients (Page Blade)
     */
    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->paginate(5);
        return view('backend.clients.index', compact('clients'));
    }

    public function show($id)
    {
        // Récupérer le client avec ses vols, hôtels et locations de voitures
        $client = Client::findOrFail($id);
    
        // Récupérer les données associées
        $hotels = Hotel::where('client_id', $client->id)->get();
        $flights = Flight::where('client_id', $client->id)->get();
        $carLocations = CarLocation::where('client_id', $client->id)->get();
        
        $allReservations = $flights->concat($hotels)->concat($carLocations);

        // dd($allReservations[0]->destination);
        // Retourner la vue avec les données du client
        return view('backend.clients.detailsclients', compact('allReservations', 'client'));
    }
    
    

    /**
     * Récupère les clients en JSON pour l'affichage dynamique
     */
    public function fetchClients(Request $request)
    {
        $clients = Client::orderBy('created_at', 'desc')->paginate(5);
        
        return response()->json($clients);
    }

    /**
     * Supprime un client
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client supprimé avec succès']);
    }
}
