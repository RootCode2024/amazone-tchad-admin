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
                                        <div x-data="statusManager(reservation.id, 'flight', reservation.status)">
                                            <button @click="updateStatus(reservation.id)" 
                                                    class="btn btn-sm" 
                                                    :class="status === 'pending' ? 'btn-warning' : (status === 'validated' ? 'btn-success' : 'btn-danger')"
                                                    >
                                                    <span x-text="status === 'pending' ? 'En Attente' : (status === 'validated' ? 'Validé' : 'Rejeté')"></span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm" @click="voirReservation(reservation.client_id, reservation.id)">
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
                                <th>ID Client</th>
                                <th>Chambre</th>
                                <th>Date de la demande</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="reservation in reservations.data" :key="reservation.id">
                                <tr>
                                    <td x-text="reservation.id"></td>
                                    <td x-data="{ clientName: 'Chargement...' }" 
                                        x-init="fetchClientInfos(reservation.client_id).then(name => clientName = name)">
                                        <span x-text="clientName"></span>
                                    </td>

                                    <td x-text="reservation.number_of_room"></td>
                                    <td x-text="formatDate(reservation.created_at)"></td>
                                    <td class="text-center">
                                        <div x-data="statusManager(reservation.id, 'hotel', reservation.status)">
                                            <button @click="updateStatus(reservation.id)" 
                                                    class="btn btn-sm" 
                                                    :class="status === 'pending' ? 'btn-warning' : (status === 'validated' ? 'btn-success' : 'btn-danger')"
                                                    >
                                                    <span x-text="status === 'pending' ? 'En Attente' : (status === 'validated' ? 'Validé' : 'Rejeté')"></span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm" @click="voirReservation(reservation.client_id, reservation.id)">
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


            <!-- Tableau pour Locations de voitures -->
            <template x-if="typeReservationModel === 'locations'">
                <div>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Age</th>
                                <th>Téléphone</th>
                                <th>Date de la demande</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="reservation in reservations.data" :key="reservation.id">
                                <tr>
                                    <td>4</td>
                                    <td>
                                        <span class="fw-bold">r</span>
                                        <span >e</span>
                                    </td>
                                    <td >e</td>
                                    <td >e</td>
                                    <td >e</td>
                                    <td>
                                        e
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm" @click="voirReservation(reservation.client_id, reservation.id)">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" @click="supprimerReservation('carlocation', reservation.id)">
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
                clientInfos: {}, 
                isLoading: false,

                init() {
                    console.log("Initialisation du composant...");
                    this.fetchReservationsForType();
                },

                updateTable() {
                    console.log("Mise à jour du tableau pour :", this.typeReservationModel);
                    this.reservations.current_page = 1;
                    this.fetchReservationsForType();
                },

                getApiEndpoint() {
                    const endpoints = {
                        vols: `${this.baseUrl}fetchVols`,
                        hotels: `${this.baseUrl}fetchHotels`,
                        locations: `${this.baseUrl}fetchLocations`
                    };
                    return endpoints[this.typeReservationModel] || this.baseUrl;
                },

                fetchReservationsForType() {
                    console.log("Fetching reservations for type:", this.typeReservationModel);
                    const endpoint = this.getApiEndpoint();
                    if (!endpoint) {
                        console.error("Endpoint introuvable pour le type de réservation :", this.typeReservationModel);
                        return;
                    }
                    this.fetchReservations(endpoint);
                },

                fetchReservations(url) {
                    this.isLoading = true; // Active le chargement
                    console.log("Appel API :", url);

                    axios.get(url, {
                        params: {
                            page: this.reservations.current_page,
                            per_page: this.reservations.per_page
                        }
                    })
                    .then(response => {
                        console.log("Données reçues :", response.data);
                        this.reservations = response.data;
                        this.totalPages = this.reservations.last_page;
                    })
                    .catch(error => {
                        console.error("Erreur lors du chargement des réservations :", error);
                        alert("Une erreur est survenue lors du chargement des réservations.");
                    })
                    .finally(() => {
                        this.isLoading = false; // Désactive le chargement
                    });
                },

                async fetchClientInfos(id) {
                    if (!id) return "Client inconnu";

                    // Vérifier si l'information du client est déjà chargée
                    if (this.clientInfos[id]) {
                        return this.clientInfos[id];
                    }

                    try {
                        let response = await axios.get(`${window.location.origin}/admin/clients/${id}/details`);
                        if (response.data.success) {
                            let clientName = response.data.data.name || "Nom inconnu";
                            this.clientInfos[id] = clientName; // Stocker en cache
                            return clientName;
                        } else {
                            console.error("Erreur lors de la récupération des infos client.");
                            return "Erreur client";
                        }
                    } catch (error) {
                        console.error("Erreur réseau ou serveur :", error);
                        return "Erreur serveur";
                    }
                },

                supprimerReservation(type, id) {
                    if (!confirm('Voulez-vous vraiment supprimer cette réservation ?')) return;

                    let url = `${window.location.origin}/admin/reservations/delete/${type}/${id}`;

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

                voirReservation(client_id, reservation_id) {
                    window.location.href = `${window.location.origin}/admin/reservations/${client_id}/${reservation_id}`;
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

            Alpine.data('clientTable', () => ({
                clientInfos: {}, // Stockage des infos client
        
                fetchClientInfos(id) {
                    if (!id) return Promise.resolve("Client inconnu");
        
                    return axios.get(`${window.location.origin}/admin/clients/${id}/details`)
                        .then(response => {
                            if (response.data.success) {
                                return response.data.data.name || "Nom inconnu";
                            } else {
                                console.error("Erreur lors de la récupération des infos client.");
                                return "Erreur client";
                            }
                        })
                        .catch(error => {
                            console.error("Erreur réseau ou serveur :", error);
                            return "Erreur serveur";
                        });
                }
            }));
        
            Alpine.data('statusManager', (id, type, initialStatus) => ({
                status: initialStatus,
        
                updateStatus() {
                    const newStatus = this.status === 'pending' ? 'validated' :
                                      (this.status === 'validated' ? 'rejected' : 'pending');
        
                    let endpoint = `${window.location.origin}/admin/reservations/${id}/update-status-${type.toLowerCase()}`;
        
                    axios.post(endpoint, { status: newStatus }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.status = newStatus;
                            alert('Statut mis à jour avec succès !');
                        } else {
                            alert('Erreur lors de la mise à jour du statut.');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur réseau ou serveur:', error);
                        alert('Une erreur est survenue.');
                    });
                }
            }));
        });
    </script>
        
    @endsection
    