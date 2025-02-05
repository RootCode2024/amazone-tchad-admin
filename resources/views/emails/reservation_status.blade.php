<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
        .content p {
            margin: 10px 0;
        }
        .status {
            padding: 12px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 20px;
        }
        .validated {
            background-color: #28a745;
            color: white;
        }
        .rejected {
            background-color: #dc3545;
            color: white;
        }
        .pending {
            background-color: #ffc107;
            color: black;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .cta-button {
            display: block;
            width: 80%;
            margin: 20px auto;
            text-align: center;
            padding: 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .cta-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Statut de votre réservation</h1>
        </div>
        
        <div class="content">
            <p><strong>ID Réservation :</strong> {{ $reservation->id }}</p>
            <p><strong>Client :</strong> {{ $reservation->client->firstname }} {{ $reservation->client->lastname }}</p>
            <p><strong>Email :</strong> {{ $reservation->client->email }}</p>
            <p><strong>Téléphone :</strong> {{ $reservation->client->phone }}</p>
            <p><strong>Type de Réservation :</strong> 
                @if ($reservation instanceof \App\Models\Flight)
                    Vol
                @elseif ($reservation instanceof \App\Models\Hotel)
                    Hôtel
                @elseif ($reservation instanceof \App\Models\CarLocation)
                    Location de Voiture
                @else
                    Non spécifié
                @endif
            </p>
            <p><strong>Date de Réservation :</strong> 
                {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y à H:i') }}
            </p>

            @if ($reservation->status === 'validated')
                <div class="status validated">✅ Votre réservation a été validée. Nous vous recontacterons sous peu.</div>
            @elseif($reservation->status === 'rejected')
                <div class="status rejected">❌ Votre réservation a été rejetée. Si erreur, contactez-nous au <strong style="color:blue">{{ env('APP_PHONE') }}</strong>.</div>
            @else
                <div class="status pending">⏳ Votre réservation est en attente de validation. Nous vous recontacterons sous peu.</div>
            @endif
        </div>

        <div class="footer">
            <p>Merci de choisir <strong>Amazone Tchad</strong> et pour votre confiance.</p>
            <p>Équipe <a href="{{ config('app.url') }}">{{ config('app.name', 'Amazone Tchad') }}</a></p>
        </div>
    </div>
</body>
</html>
