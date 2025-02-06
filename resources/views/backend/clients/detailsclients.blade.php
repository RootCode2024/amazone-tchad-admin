@extends('backend.layouts.app')

@section('head')
<title>Détails du client - {{ config('app.name', 'Laravel') }}</title>
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
                                @if ($reservation instanceof \App\Models\Hotel)
                                    {{ (\App\Models\Airport::where("id", $reservation->country_id)->first())->country ?? '' }}
                                @else
                                    {{ (\App\Models\Airport::where("id", $reservation->destination)->first())->country ?? '' }}
                                @endif
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
                                <!-- Alpine.js pour gérer le statut -->
                                <div x-data="statusManager('{{ $reservation->id }}', '{{ get_class($reservation) }}', '{{ $reservation->status }}')">
                                    <!-- Bouton de statut qui ouvre SweetAlert2 -->
                                    <button
                                        class="btn btn-sm"
                                        :class="status === 'pending' ? 'btn-warning' : (status === 'validated' ? 'btn-success' : 'btn-danger')"
                                        @click="openModal()">
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
        const appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');
    
        Alpine.data('statusManager', (id, type, initialStatus) => ({
            id,
            type,
            status: initialStatus,
    
            // Ouvre SweetAlert2 pour sélectionner le statut
            openModal() {
                Swal.fire({
                    title: 'Changer le statut',
                    text: "Sélectionnez un nouveau statut pour cette réservation :",
                    icon: 'question',
                    input: 'select',
                    inputOptions: {
                        pending: 'En attente',
                        validated: 'Validé',
                        rejected: 'Rejeté'
                    },
                    inputValue: this.status, // Pré-rempli avec le statut actuel
                    showCancelButton: true,
                    confirmButtonText: 'Confirmer',
                    cancelButtonText: 'Annuler',
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.confirmStatusChange(result.value);
                    }
                });
            },
    
            // Confirme le changement de statut et envoie la requête
            confirmStatusChange(newStatus) {
                let endpoint = '';
                if (this.type.includes('Flight')) endpoint = `${appUrl}/admin/reservations/${this.id}/update-status-flight`;
                else if (this.type.includes('Hotel')) endpoint = `${appUrl}/admin/reservations/${this.id}/update-status-hotel`;
                else if (this.type.includes('CarLocation')) endpoint = `${appUrl}/admin/reservations/${this.id}/update-status-car-location`;
    
                console.log("URL API appelée:", endpoint);
    
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
                        this.status = newStatus;
                        Swal.fire({
                            title: 'Succès !',
                            text: 'Le statut a été mis à jour avec succès.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Erreur',
                            text: 'Une erreur est survenue lors de la mise à jour du statut.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur réseau ou serveur:', error);
                    Swal.fire({
                        title: 'Erreur',
                        text: 'Une erreur s\'est produite. Veuillez réessayer.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            }
        }));
    });
</script>
    
@endsection
