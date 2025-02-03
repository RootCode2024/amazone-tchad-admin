@extends('backend.layouts.app')

@section('head')
<title>Reservations - Amazone Tchad Admin</title>
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <span>Accueil</span>
            </li>
            <li class="breadcrumb-item active">
                <span>Reservations</span>
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')

<div x-data="reservationTable">
    <!-- Sélection du type de réservation -->
    <select name="typeReservation" id="typeReservation" x-model="typeReservationModel" @change="updateTable()">
        <option value="vols">Vols</option>
        <option value="hotels">Hôtels</option>
        <option value="volshotels">Vols + Hôtels</option>
        <option value="locations">Locations de voitures</option>
    </select>

    <div class="container mt-5">
        <h2 class="mb-4">
            Réservations (<span x-text="typeReservationModel"></span>)
        </h2>

        <!-- Tableau pour les vols -->
        <template x-if="typeReservationModel === 'vols'">
            <div>
                <table class="table table-striped table-hover shadow-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Détails du Vol</th>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Date de la demande</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="reservation in reservations.data" :key="reservation.id">
                            <tr class="align-middle">
                                <td class="text-center fw-bold" x-text="reservation.id"></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-primary">
                                            <i class="fas fa-plane-departure"></i> 
                                            <span x-text="reservation.flight_type === 'one-way' ? 'Aller simple' : (reservation.flight_type === 'round-trip' ? 'Aller-retour' : reservation.flight_type)"></span>
                                        </span>
        
                                        <span class="badge bg-info text-white mt-1">
                                            <i class="fas fa-ticket-alt"></i> 
                                            <span x-text="reservation.flight_class === 'economy' ? 'Classe Économie' : 
                                                (reservation.flight_class === 'business' ? 'Classe Affaires' : 
                                                (reservation.flight_class === 'premium' ? 'Première Classe' : reservation.flight_class))">
                                            </span>
                                        </span>
        
                                        <hr class="my-1">
                                        <span class="fw-bold text-success">
                                            <i class="fas fa-map-marker-alt"></i> 
                                            {{-- <span x-text="reservation.countries ? reservation.countries.country : ''"></span> 
                                            → 
                                            <span x-text="reservation.destination ? reservation.destinations.country : ''"></span> --}}
                                        </span>
                                        
                                        <span class="text-muted">
                                            <i class="fas fa-calendar-alt"></i> 
                                            <span x-text="reservation.departure_date"></span> 
                                            <span x-show="reservation.return_date"> - </span> 
                                            <span x-text="reservation.return_date"></span>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold" x-text="reservation.client ? reservation.client.firstname : ''"></span>
                                    <span x-text="reservation.client ? reservation.client.lastname : ''"></span>
                                </td>
                                <td x-text="reservation.client ? reservation.client.phone : ''"></td>
                                <td x-text="reservation.created_at"></td>
                                <td class="text-center">
                                    <span class="badge" 
                                          :class="reservation.status === 'pendding' ? 'bg-warning text-dark' : 'bg-success'" 
                                          x-text="reservation.status === 'pendding' ? 'En attente' : 'Confirmée'">
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm" @click="supprimerReservation(reservation.id)">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
        
                <!-- Pagination -->
                <nav class="mt-3">
                    <ul class="pagination justify-content-center">
                        <li class="page-item" :class="{ 'disabled': !reservations.prev_page_url }">
                            <button class="page-link" @click="fetchReservations(reservations.prev_page_url)">
                                <i class="fas fa-chevron-left"></i> Précédent
                            </button>
                        </li>
                        <template x-for="page in totalPages" :key="page">
                            <li class="page-item" :class="{ 'active': reservations.current_page === page }">
                                <button class="page-link" @click="jumpToPage(page)" x-text="page"></button>
                            </li>
                        </template>
                        <li class="page-item" :class="{ 'disabled': !reservations.next_page_url }">
                            <button class="page-link" @click="fetchReservations(reservations.next_page_url)">
                                Suivant <i class="fas fa-chevron-right"></i>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </template>
        

        <!-- Tableau pour les hôtels -->
        <template x-if="typeReservationModel === 'hotels'">
            <div>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Hôtel</th>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Date de la demande</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="reservation in reservations.data" :key="reservation.id">
                            <tr>
                                <td x-text="reservation.id"></td>
                                <td x-text="reservation.hotel_name"></td>
                                <td x-text="reservation.client"></td>
                                <td x-text="reservation.phone"></td>
                                <td x-text="reservation.created_at"></td>
                                <td>
                                    <span class="badge" 
                                          :class="reservation.status === 'pendding' ? 'bg-success' : 'bg-danger'" 
                                          x-text="reservation.status"></span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Voir</a>
                                    <button class="btn btn-danger btn-sm" @click="supprimerReservation(reservation.id)">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <!-- Pagination -->
                <nav>
                    <ul class="pagination">
                        <li class="page-item" :class="{ 'disabled': !reservations.prev_page_url }">
                            <button class="page-link" @click="fetchReservations(reservations.prev_page_url)">Précédent</button>
                        </li>
                        <template x-for="page in totalPages" :key="page">
                            <li class="page-item" :class="{ 'active': reservations.current_page === page }">
                                <button class="page-link" 
                                        @click="jumpToPage(page)" 
                                        x-text="page"></button>
                            </li>
                        </template>
                        <li class="page-item" :class="{ 'disabled': !reservations.next_page_url }">
                            <button class="page-link" @click="fetchReservations(reservations.next_page_url)">Suivant</button>
                        </li>
                    </ul>
                </nav>
            </div>
        </template>

        <!-- Tableau pour Vols + Hôtels -->
        <template x-if="typeReservationModel === 'volshotels'">
            <div>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Vol / Hôtel</th>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Date de la demande</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="reservation in reservations.data" :key="reservation.id">
                            <tr>
                                <td x-text="reservation.id"></td>
                                <td>
                                    <div>
                                        <strong>Vol:</strong> <span x-text="reservation.flight_number"></span><br>
                                        <strong>Hôtel:</strong> <span x-text="reservation.hotel_name"></span>
                                    </div>
                                </td>
                                <td x-text="reservation.client"></td>
                                <td x-text="reservation.phone"></td>
                                <td x-text="reservation.created_at"></td>
                                <td>
                                    <span class="badge" 
                                          :class="reservation.status === 'pendding' ? 'bg-success' : 'bg-danger'" 
                                          x-text="reservation.status"></span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Voir</a>
                                    <button class="btn btn-danger btn-sm" @click="supprimerReservation(reservation.id)">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <!-- Pagination -->
                <nav>
                    <ul class="pagination">
                        <li class="page-item" :class="{ 'disabled': !reservations.prev_page_url }">
                            <button class="page-link" @click="fetchReservations(reservations.prev_page_url)">Précédent</button>
                        </li>
                        <template x-for="page in totalPages" :key="page">
                            <li class="page-item" :class="{ 'active': reservations.current_page === page }">
                                <button class="page-link" 
                                        @click="jumpToPage(page)" 
                                        x-text="page"></button>
                            </li>
                        </template>
                        <li class="page-item" :class="{ 'disabled': !reservations.next_page_url }">
                            <button class="page-link" @click="fetchReservations(reservations.next_page_url)">Suivant</button>
                        </li>
                    </ul>
                </nav>
            </div>
        </template>

        <!-- Tableau pour Locations de voitures -->
        <template x-if="typeReservationModel === 'locations'">
            <div>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Véhicule</th>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Date de la demande</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="reservation in reservations.data" :key="reservation.id">
                            <tr>
                                <td x-text="reservation.id"></td>
                                <td x-text="reservation.car_model"></td>
                                <td x-text="reservation.client"></td>
                                <td x-text="reservation.phone"></td>
                                <td x-text="reservation.created_at"></td>
                                <td>
                                    <span class="badge" 
                                          :class="reservation.status === 'pendding' ? 'bg-success' : 'bg-danger'" 
                                          x-text="reservation.status"></span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Voir</a>
                                    <button class="btn btn-danger btn-sm" @click="supprimerReservation(reservation.id)">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <!-- Pagination -->
                <nav>
                    <ul class="pagination">
                        <li class="page-item" :class="{ 'disabled': !reservations.prev_page_url }">
                            <button class="page-link" @click="fetchReservations(reservations.prev_page_url)">Précédent</button>
                        </li>
                        <template x-for="page in totalPages" :key="page">
                            <li class="page-item" :class="{ 'active': reservations.current_page === page }">
                                <button class="page-link" 
                                        @click="jumpToPage(page)" 
                                        x-text="page"></button>
                            </li>
                        </template>
                        <li class="page-item" :class="{ 'disabled': !reservations.next_page_url }">
                            <button class="page-link" @click="fetchReservations(reservations.next_page_url)">Suivant</button>
                        </li>
                    </ul>
                </nav>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('reservationTable', () => ({
        reservations: { data: [], total: 0, per_page: 5, current_page: 1, last_page: 1 },
        totalPages: 1,
        // Valeur par défaut
        typeReservationModel: 'vols',

        init() {
            this.fetchReservationsForType();
        },

        updateTable() {
            // Remise à zéro de la page courante puis rafraîchissement des données
            this.reservations.current_page = 1;
            this.fetchReservationsForType();
        },

        fetchReservationsForType() {
            let endpoint = '/admin/reservations/';
            if (this.typeReservationModel === 'vols') {
                endpoint += 'fetchVols';
            } else if (this.typeReservationModel === 'hotels') {
                endpoint += 'fetchHotels';
            } else if (this.typeReservationModel === 'volshotels') {
                endpoint += 'fetchVolsHotels';
            } else if (this.typeReservationModel === 'locations') {
                endpoint += 'fetchLocations';
            }
            this.fetchReservations(endpoint);
        },

        fetchReservations(url) {
            axios.get(url, {
                params: {
                    page: this.reservations.current_page,
                    per_page: this.reservations.per_page
                }
            })
            .then(response => {
                this.reservations = response.data;
                this.totalPages = this.reservations.last_page;
            })
            .catch(error => {
                console.error(error);
            });
        },

        jumpToPage(page) {
            this.reservations.current_page = page;
            this.fetchReservationsForType();
        },

        supprimerReservation(id) {
            if (!confirm('Voulez-vous vraiment supprimer cette réservation ?')) return;
            axios.delete(`/admin/reservations/delete/${id}`)
                .then(() => {
                    this.fetchReservationsForType();
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }));
});
</script>

@endsection
