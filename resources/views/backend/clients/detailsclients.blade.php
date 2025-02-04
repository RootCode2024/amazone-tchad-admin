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
                                {{ (\App\Models\Airport::where("id", $reservation->destination)->first())->country }}
                            </td>
                            <td>
                                <span>
                                    Départ : {{ \Carbon\Carbon::parse($reservation->departure_date ?? $reservation->arrival_date)->locale('fr')->isoFormat('D MMMM YYYY') }}
                                </span>
                                <br>
                                <span>
                                    Retour : {{ \Carbon\Carbon::parse($reservation->return_date ?? $reservation->ended_date)->locale('fr')->isoFormat('D MMMM YYYY') }}
                                </span>
                            </td>
                            <td>
                                <div x-data="statusManager('{{ $reservation->id }}', '{{ get_class($reservation) }}', '{{ $reservation->status }}')">
                                    <button
                                        class="btn btn-sm"
                                        :class="status === 'pending' ? 'btn-warning' : (status === 'validated' ? 'btn-success' : 'btn-danger')"
                                        @click="updateStatus()">
                                        <span x-text="status === 'pending' ? 'En Attente' : (status === 'validated' ? 'Validé' : 'Rejeté')"></span>
                                    </button>
                                </div>
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
    document.addEventListener('alpine:init', () => {
        Alpine.data('statusManager', (id, type, initialStatus) => ({
            status: initialStatus, // État initial du statut

            updateStatus() {
                const newStatus = this.status === 'pending' ? 'validated' :
                                  (this.status === 'validated' ? 'rejected' : 'pending');

                // API endpoint basé sur le type de réservation
                let endpoint = '';
                if (type.includes('Flight')) endpoint = `/reservations/${id}/update-status-flight`;
                else if (type.includes('Hotel')) endpoint = `/reservations/${id}/update-status-hotel`;
                else if (type.includes('CarLocation')) endpoint = `/reservations/${id}/update-status-car-location`;

                // Envoyer la requête de mise à jour
                fetch(endpoint, {
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
                        // Mettre à jour le statut localement
                        this.status = newStatus;
                        alert('Statut mis à jour avec succès !');
                    } else {
                        alert('Erreur lors de la mise à jour du statut.');
                    }
                })
                .catch(error => {
                    console.error('Erreur réseau ou serveur:', error);

                    // Vérifier si le serveur a renvoyé une page HTML (erreur 500)
                    if (error instanceof SyntaxError) {
                        alert('Erreur serveur : vérifiez les logs Laravel.');
                    } else {
                        alert('Une erreur est survenue.');
                    }
                });
            }
        }));
    });
</script>

@endsection
