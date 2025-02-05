<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/changeStatusReservation.css') }}">
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Status de votre réservation</h1>
        </div>
        <div class="content">
            <p><strong>ID Réservation : </strong> {{ $reservation->id }}</p>
            <p><strong>Client : </strong> {{ $reservation->client->firstname }} {{ $reservation->client->lastname }}</p>
            <p><strong>Email : </strong> {{ $reservation->client->email }}</p>
            <p><strong>Téléphone : </strong> {{ $reservation->client->phone }}</p>
            <p><strong>Type de Réservation : </strong> 
                @if ($reservation instanceof \App\Models\Flight)
                    Vol
                @elseif ($reservation instanceof \App\Models\Hotel)
                    Hôtel
                @elseif ($reservation instanceof \App\Models\CarLocation)
                    Location de Voiture
                @else
                    -----------
                @endif
            </p>
            <p><strong>Date de Réservation : </strong>{{ \Carbon\Carbon::parse($reservation->created_at)->format('d m Y à H:i') }}</p>
            @if ($reservation->status === 'validated')
                <div class="status validated">Votre réservation a été validée. Nous vous recontacterons sous peu.</div>
            @elseif($reservation->status === 'rejected')
                <div class="status rejected">Votre reservation à été rejetée. Si erreur veuillez nous contacter au <span style="color:blue">123456789</span></div>
            @else
                <div class="status pending">Votre réservation est en attente de validation. Nous vous recontacterons sous peu.</div>
            @endif
        </div>
        <div class="footer">
            <p>Merci de pour la confiance que vous nous portez.</p>
            <p>Equipe <a href="{{ config('app.url') }}">{{ config('app.name', 'Amazone Tchad') }}</a></p>
        </div>
    </div>
</body>
</html>