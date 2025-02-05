@extends('backend.layouts.app')

@section('head')
<title>Détails de la Réservation - Amazone Tchad Admin</title>
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Réservations</a></li>
            <li class="breadcrumb-item active"><span>Détails</span></li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3><i class="fas fa-info-circle"></i> Informations de la Réservation</h3>
        </div>
        <div class="card-body">

            @if ($type == 'Vol')
                <h5 class="text-center text-primary fw-bold fs-2"><i class="fas fa-plane"></i> Vol</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Client ID :</strong> {{ $reservation->client_id }}</p>
                        
                        <p><strong>Origine :</strong> {{ $reservation->country ? $reservation->country->country : 'Non spécifié' }}</p>
                        <p><strong>Date de Départ :</strong>
                            {{ \Carbon\Carbon::parse($reservation->departure_date)->locale('fr')->isoFormat('D MMMM YYYY') }}
                        </p>
                        <p><strong>Nombre de Passager (s) :</strong> {{ $reservation->passengers }}</p>
                        <p><strong>Classe :</strong>
                            @if ($reservation->flight_class === 'economy')
                                Economie
                            @elseif ($reservation->flight_class === 'premium')
                                Première
                            @else
                                Business
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Statut :</strong> 
                            <span class="badge {{ $reservation->status == 'confirmé' ? 'bg-success' : 'bg-warning' }}">
                                @if ($reservation->status === 'pending')
                                    En Attente
                                @elseif ($reservation->status === 'validated')
                                    Validé
                                @else
                                    Rejeté
                                @endif
                            </span>
                        </p>
                        <p><strong>Destination :</strong> 
                            {{ (\App\Models\Airport::where('id', $reservation->destination)->first())->country }}
                        </p>
                        @isset($reservation->return_date)
                        <p><strong>Date de Retour :</strong> 
                                {{ \Carbon\Carbon::parse($reservation->return_date)->locale('fr')->isoFormat('D MMMM YYYY') }}
                        </p></div>
                        @endisset
                        <p><strong>Type de Vol :</strong> 
                            @if ($reservation->flight_type === 'one-way')
                                Aller Simple
                            @elseif ($reservation->flight_type === 'round-trip')
                                Aller - Retour
                            @else
                                Multi-destination
                            @endif
                        </p>
                    </div>
                </div>
            @elseif ($type == 'Hôtel')
                <h5 class="text-center text-primary fw-bold fs-2"><i class="fas fa-hotel"></i> Hôtel</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Ville :</strong> {{ $reservation->country->country }}</p>
                        <p><strong>Date d'entrée :</strong> {{ $reservation->arrival_date }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nombre de Chambre :</strong> {{ $reservation->number_of_room }}</p>
                        <p><strong>Date de sortie :</strong> {{ $reservation->return_date }}</p>
                    </div>
                </div>
            @elseif ($type == 'Location de Voiture')
                <h5 class="text-center text-primary fw-bold fs-2"><i class="fas fa-car"></i> Location de Voiture</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Modèle :</strong> {{ $reservation->car_model }}</p>
                        <p><strong>Agence :</strong> {{ $reservation->agency_name }}</p>
                        <p><strong>Lieu de prise en charge :</strong> {{ $reservation->pickup_location }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date de début :</strong> {{ $reservation->start_date }}</p>
                        <p><strong>Date de retour :</strong> {{ $reservation->end_date }}</p>
                    </div>
                </div>
            @endif

            <hr>
            <h5><i class="fas fa-user"></i> Client</h5>
            <p><strong>Nom :</strong> {{ $reservation->client->firstname }} {{ $reservation->client->lastname }}</p>
            <p><strong>Téléphone :</strong> {{ $reservation->client->phone }}</p>
            <p><strong>Email :</strong> {{ $reservation->client->email }}</p>

            <div class="text-center mt-4">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour liste des clients
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
