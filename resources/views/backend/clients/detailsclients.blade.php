@extends('backend.layouts.app')

@section('head')
<title>Détails du Client - Amazone Tchad Admin</title>
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item"><span>Accueil</span></li>
            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
            <li class="breadcrumb-item active"><span>Détails</span></li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Détails du Client</h2>

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3><i class="fas fa-user"></i> Informations du Client</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5><i class="fas fa-user"></i> Nom :</h5>
                    <p>{{ $client->firstname }} {{ $client->lastname }}</p>
                </div>
                <div class="col-md-6">
                    <h5><i class="fas fa-phone"></i> Téléphone :</h5>
                    <p>{{ $client->phone ?? 'Non renseigné' }}</p>
                </div>
                <div class="col-md-6">
                    <h5><i class="fas fa-envelope"></i> Email :</h5>
                    <p>{{ $client->email ?? 'Non renseigné' }}</p>
                </div>
            </div>

            <hr>

            <!-- Réservations -->
            <h4 class="text-center text-secondary"><i class="fas fa-clipboard-list"></i> Réservations</h4>
            <table class="table table-striped mt-3">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Type de Réservation</th>
                        <th>Destination</th>
                        <th>Date de début</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Fusionner toutes les réservations dans un seul tableau
                        $allReservations = $flights->merge($hotels)->merge($carLocations);
                    @endphp

                    @forelse($allReservations as $reservation)
                        <tr class="align-middle text-center">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                @if ($reservation instanceof \App\Models\Flight)
                                    Vol
                                @elseif ($reservation instanceof \App\Models\Hotel)
                                    Hôtel
                                @elseif ($reservation instanceof \App\Models\CarLocation)
                                    Location de Voiture
                                @else
                                    Non spécifié
                                @endif
                            </td>
                            <td>
                                @if ($reservation instanceof \App\Models\Flight)
                                    {{ $reservation->country->country }}
                                @elseif ($reservation instanceof \App\Models\Hotel)
                                    {{ $reservation->country->country }}
                                @elseif ($reservation instanceof \App\Models\CarLocation)
                                    {{ $reservation->country->place }}
                                @else
                                    Non spécifié
                                @endif
                                {{ $reservation->name ?? $reservation->title }}
                            </td>
                            <td>{{ $reservation->created_at->format('d F Y') }}</td>
                            <td>
                                <span class="badge {{ $reservation->status === 'pending' ? 'bg-warning' : 'bg-success' }}">
                                    {{ $reservation->status === 'pending' ? 'En attente' : 'Validé' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucune réservation trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-center mt-4">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
