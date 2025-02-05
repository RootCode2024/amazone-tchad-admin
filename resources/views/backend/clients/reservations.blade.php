@extends('backend.layouts.app')

@section('head')
    <title>Réservations - Amazone Tchad Admin</title>
@endsection

@section('breadcrumb')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <span>Accueil</span>
                </li>
                <li class="breadcrumb-item active">
                    <span>Réservations</span>
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
                                <th>Statut</th>
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
                                                <span x-text="reservation.countries ? reservation.countries.country : ''"></span>
                                                →
                                                <span x-text="reservation.destination ? reservation.destinations.country : ''"></span>
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
                                    <td x-text="formatDate(reservation.created_at)"></td>

                                    <td class="text-center">
                                        <button @click="updateStatus(reservation.id)" class="btn btn-sm">
                                            <span class="badge"
                                                :class="{
                                                    'bg-warning text-dark': reservation.status === 'pending',
                                                    'bg-success': reservation.status === 'validated',
                                                    'bg-danger': reservation.status === 'rejected'
                                                }"
                                                x-text="reservation.status === 'pending' ? 'En attente' :
                                                        (reservation.status === 'validated' ? 'Validée' : 'Rejetée')">
                                            </span>
                                        </button>
                                        
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm" @click="voirReservation(reservation.id)">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" @click="supprimerReservation('flight', reservation.id)">
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
                                <th>Client</th>
                                <th>Chambre</th>
                                <th>Téléphone</th>
                                <th>Date de la demande</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="reservation in reservations.data" :key="reservation.id">
                                <tr>
                                    <td x-text="reservation.id"></td>
                                    <td>
                                        <span x-init="console.log(reservation.client)" x-text="reservation.client ? reservation.client.firstname : 'Non disponible'"></span>
                                    </td>
                                    
                                    
                                    <td x-text="reservation.number_of_room"></td>
                                    <td x-text="reservation.client_id"></td>
                                    <td x-text="formatDate(reservation.created_at)"></td>
                                    <td>
                                        <span class="badge" 
                                              :class="reservation.status === 'pending' ? 'bg-warning text-dark' : 'bg-danger'" 
                                              x-text="reservation.status === 'pending' ? 'En attente' : 'Rejetée'"></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" @click="voirReservationHotel(reservation.id)">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" @click="supprimerReservation('hotel', reservation.id)">
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
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="reservation in reservations.data" :key="reservation.id">
                                <tr>
                                    <td x-text="reservation.id"></td>
                                    <td>
                                        <div>
                                            <strong>Vol :</strong> <span x-text="reservation.flight_number"></span><br>
                                            <strong>Hôtel :</strong> <span x-text="reservation.hotel_name"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold" x-text="reservation.client ? reservation.client.firstname : ''"></span>
                                        <span x-text="reservation.client ? reservation.client.lastname : ''"></span>
                                    </td>
                                    <td x-text="reservation.client ? reservation.client.phone : ''"></td>
                                    <td x-text="formatDate(reservation.created_at)"></td>
                                    <td>
                                        <span class="badge" 
                                              :class="reservation.status === 'pending' ? 'bg-warning text-dark' : 'bg-danger'" 
                                              x-text="reservation.status === 'pending' ? 'En attente' : 'Rejetée'"></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" @click="voirReservationVolHotel(reservation.id)">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" @click="supprimerReservation('volhotel', reservation.id)">
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
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="reservation in reservations.data" :key="reservation.id">
                                <tr>
                                    <td x-text="reservation.id"></td>
                                    <td x-text="reservation.car_model"></td>
                                    <td>
                                        <span class="fw-bold" x-text="reservation.client ? reservation.client.firstname : ''"></span>
                                        <span x-text="reservation.client ? reservation.client.lastname : ''"></span>
                                    </td>
                                    <td x-text="reservation.client ? reservation.client.phone : ''"></td>
                                    <td x-text="formatDate(reservation.created_at)"></td>
                                    <td>
                                        <span class="badge" 
                                              :class="reservation.status === 'pending' ? 'bg-warning text-dark' : 'bg-danger'" 
                                              x-text="reservation.status === 'pending' ? 'En attente' : 'Rejetée'"></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" @click="voirReservationLocation(reservation.id)">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" @click="supprimerReservation('location', reservation.id)">
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
        </div>
    </div>
    
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('reservationTable', () => ({
            reservations: { data: [], total: 0, per_page: 5, current_page: 1, last_page: 1 },
            totalPages: 1,
            typeReservationModel: 'vols',
            baseUrl: `${window.location.origin}/admin/reservations/`,
    
            init() {
                this.fetchReservationsForType();
            },
    
            updateTable() {
                this.reservations.current_page = 1;
                this.fetchReservationsForType();
            },
    
            getApiEndpoint() {
                const endpoints = {
                    vols: `${this.baseUrl}fetchVols`,
                    hotels: `${this.baseUrl}fetchHotels`,
                    volshotels: `${this.baseUrl}fetchVolsHotels`,
                    locations: `${this.baseUrl}fetchLocations`
                };
                return endpoints[this.typeReservationModel] || this.baseUrl;
            },
    
            fetchReservationsForType() {
                const endpoint = this.getApiEndpoint();
                if (!endpoint) {
                    console.error("Endpoint introuvable pour le type de réservation :", this.typeReservationModel);
                    return;
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
                    console.error("Erreur lors du chargement des réservations :", error);
                    alert("Une erreur est survenue lors du chargement des réservations.");
                });
            },
    
            supprimerReservation(type, id) {
                if (!confirm('Voulez-vous vraiment supprimer cette réservation ?')) return;
    
                let url = '';
                if (type === 'flight') url = `${window.location.origin}/admin/reservations/delete/flight/${id}`;
                else if (type === 'hotel') url = `${window.location.origin}/admin/reservations/delete/hotel/${id}`;
                else if (type === 'volhotel') url = `${window.location.origin}/admin/reservations/delete/volhotel/${id}`;
                else if (type === 'location') url = `${window.location.origin}/admin/reservations/delete/location/${id}`;
    
                axios.delete(url, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(() => {
                    alert("Réservation supprimée avec succès !");
                    this.fetchReservationsForType();
                })
                .catch(error => {
                    console.error("Erreur lors de la suppression :", error);
                    alert("Une erreur est survenue lors de la suppression.");
                });
            },
    
            voirReservation(id) {
                window.location.href = `${window.location.origin}/admin/reservations/flight/${id}`;
            },
    
            voirReservationHotel(id) {
                window.location.href = `${window.location.origin}/admin/reservations/hotel/${id}`;
            },
    
            voirReservationVolHotel(id) {
                window.location.href = `${window.location.origin}/admin/reservations/volhotel/${id}`;
            },
    
            voirReservationLocation(id) {
                window.location.href = `${window.location.origin}/admin/reservations/location/${id}`;
            },
    
            jumpToPage(page) {
                this.reservations.current_page = page;
                this.fetchReservationsForType();
            },
    
            formatDate(dateString) {
                if (!dateString) return "Non disponible";
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString('fr-FR', options);
            }
        }));
    });
    </script>
    @endsection
    