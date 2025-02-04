<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\CarLocation;
use App\Mail\NewReservationNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use DateTime;

class ReservationService
{
    public function createClient($data, $type)
    {
        return Client::firstOrCreate(
            ['email' => $data['email'], 'phone' => $data['phone']],
            ['lastname' => $data['lastname'], 'firstname' => $data['firstname'], 'type_of_reservation' => $type]
        );
    }

    public function createFlight($client, $data)
    {
        return Flight::create([
            'client_id' => $client->id,
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'departure_date' => $data['departure'],
            'return_date' => $data['return'] ?? null,
            'passengers' => $data['passengers'],
            'status' => 'pending',
            'flight_type' => $data['flight_type'],
            'flight_class' => $data['flight_class'],
        ]);
    }

    public function createHotel($client, $data)
    {
        return Hotel::create([
            'client_id' => $client->id,
            'country_id' => $data['destination'],
            'arrival_date' => $data['arrival_date'],
            'return_date' => $data['return_date'],
            'number_of_room' => $data['number_of_room'],
            'status' => 'pending',
        ]);
    }

    public function createCarLocation($client, $data)
    {
        return CarLocation::create([
            'client_id' => $client->id,
            'place_of_location' => $data['place_of_location'],
            'started_date' => $data['started_date'],
            'ended_date' => $data['ended_date'],
            'age' => $data['age'],
            'status' => 'pending',
        ]);
    }

    public function sendReservationEmail($reservation)
    {
        try {
            Mail::to('chist.djigalnodji@gmail.com')->send(new NewReservationNotification($reservation));
        } catch (\Exception $e) {
            Log::error("Erreur d'envoi d'email : " . $e->getMessage());
        }
    }
}
