<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Réservation</title>
</head>
<body>
    <h2>Nouvelle Réservation Reçue</h2>

    <p><strong>ID Réservation :</strong> {{ $reservation->id }}</p>
    <p><strong>Client :</strong> {{ $reservation->client->firstname }} {{ $reservation->client->lastname }}</p>
    <p><strong>Email :</strong> {{ $reservation->client->email }}</p>
    <p><strong>Téléphone :</strong> {{ $reservation->client->phone }}</p>
    <p><strong>Type de réservation :</strong> 
        @if ($reservation instanceof \App\Models\Flight)
            Vol
        @elseif ($reservation instanceof \App\Models\Hotel)
            Hôtel
        @elseif ($reservation instanceof \App\Models\CarLocation)
            Location de voiture
        @else
            Inconnu
        @endif
    </p>
    
    <p><strong>Date de réservation :</strong> {{ \Carbon\Carbon::parse($reservation->created_at)->format('d M Y H:i') }}</p>

    <p>Merci de vérifier et de traiter cette demande.</p>

    <p><strong>L'équipe Amazone Tchad</strong></p>
</body>
</html>
