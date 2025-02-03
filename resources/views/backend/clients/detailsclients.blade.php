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
<div class="container mt-2">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3><i class="fas fa-user"></i> Informations du Client</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5><i class="fas fa-user"></i> Nom :</h5>
                    <p>{{ $client->firstname }} {{ $client->lastname }}</p>
                </div>
                <div class="col-md-4">
                    <h5><i class="fas fa-phone"></i> Téléphone :</h5>
                    <p>{{ $client->phone ?? 'Non renseigné' }}</p>
                </div>
                <div class="col-md-4">
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
                        <th>Date (s)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($allReservations as $reservation)
                        <tr class="align-middle text-center">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                @if ($reservation instanceof \App\Models\Flight && $reservation instanceof \App\Models\Hotel)
                                    Vol && Hotel
                                @elseif($reservation instanceof \App\Models\Flight)
                                    Vol <span style="color:green">(
                                    @if($reservation->flight_type === 'round-trip')
                                        Aller - Retour
                                    @elseif ($reservation->flight_type === 'one-way')
                                        Aller Simple
                                    @else
                                        Multi-destination
                                    @endif )</span>
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
                                    {{ (\App\Models\Airport::where('id', $reservation->origin)->first())->country }}
                                    ->
                                    {{ (\App\Models\Airport::where('id', $reservation->destination)->first())->country }}
                                @elseif ($reservation instanceof \App\Models\Hotel)
                                    {{ $reservation->country->country }}
                                @elseif ($reservation instanceof \App\Models\CarLocation)
                                    {{ $reservation->country->country }}
                                @else
                                    Non spécifié
                                @endif
                                {{ $reservation->name ?? $reservation->title }}
                            </td>
                            <td>
                                @if ($reservation instanceof \App\Models\Flight)
                                <span>Départ le : {{ \Carbon\Carbon::parse($reservation->departure_date)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                                <br>
                                <span>Retour le : {{ \Carbon\Carbon::parse($reservation->return_date)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                                @elseif ($reservation instanceof \App\Models\Hotel)
                                <span>Début le : {{ \Carbon\Carbon::parse($reservation->arrival_date)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                                <br>
                                <span>Fin le : {{ \Carbon\Carbon::parse($reservation->return_date)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                                @elseif ($reservation instanceof \App\Models\CarLocation)
                                <span>Début le : {{ \Carbon\Carbon::parse($reservation->started_date)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                                <br>
                                <span>Fin le : {{ \Carbon\Carbon::parse($reservation->ended_date)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                                @else
                                    Non spécifié
                                @endif
                            </td>
                            @if ($reservation instanceof \App\Models\CarLocation)
                                Age du conducteur : {{ $reservation->age }} ans
                            @endif
                            <td>
                                @if ($reservation instanceof \App\Models\Flight)
                                <span
                                    x-data="{ status: '{{ $reservation->status }}' }"
                                    x-text="status === 'pending' ? 'En Attente' : (status === 'validated' ? 'Validé' : 'Rejeté')"
                                    @click="updateStatusFlight({{ $reservation->id }}, status)"
                                    style="cursor:cursor-pointer;padding:1px 2px;border-radius: 30px;background-color: gray;"
                                    >
                                </span>
                                @elseif ($reservation instanceof \App\Models\Hotel)
                                <span
                                    x-data="{ status: '{{ $reservation->status }}' }"
                                    x-text="status === 'pending' ? 'En Attente' : (status === 'validated' ? 'Validé' : 'Rejeté')"
                                    @click="updateStatusHotel({{ $reservation->id }}, status)"
                                    style="cursor:cursor-pointer;padding:1px 2px;border-radius: 30px;background-color: gray;"
                                    >
                                </span>
                                @elseif ($reservation instanceof \App\Models\CarLocation)
                                <div x-data="{ status: 'pending' }" x-init="updateStatusCarLocation({{ $reservation->id }}, status)">
                                    <button
                                        @click="status = (status === 'pending' ? 'validated' : (status === 'validated' ? 'rejected' : 'pending')); updateStatusCarLocation({{$reservation->id}}, status)">
                                        <span x-text="status === 'pending' ? 'En Attente' : (status === 'validated' ? 'Validé' : 'Rejeté')"></span>
                                    </button>
                                </div>
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('reservations.show', [$client, $reservation->id]) }}" class="btn btn-primary">
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
<script>
        function updateStatusFlight(id, currentStatus)
        {
            let newStatus = currentStatus === 'pending' ? 'validated' : (currentStatus === 'validated' ? 'rejected' : 'pending');

            fetch(`/reservations/${id}/update-status-flight`,  {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Alpine.store('status', newStatus);
                }
            });
        }
        function updateStatusHotel(id, currentStatus)
        {
            let newStatus = currentStatus === 'pending' ? 'validated' : (currentStatus === 'validated' ? 'rejected' : 'pending');

            fetch(`/reservations/${id}/update-status-hotel`,  {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Alpine.store('status', newStatus);
                }
            });
        }
        function updateStatusCarLocation(id, currentStatus)
        {
            console.log('Mis à jour pour la reservation ', id, ' avec le status ', currentStatus);
            let newStatus = currentStatus === 'pending' ? 'validated' : (currentStatus === 'validated' ? 'rejected' : 'pending');

            fetch(`/reservations/${id}/update-status-car-location`,  {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Alpine.store('status', newStatus);
                }
            });
        }
</script>
@endsection
