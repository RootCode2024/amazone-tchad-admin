@extends('backend.layouts.app')

@section('head')
    <title>Réservations - Amazone Tchad Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                            <button @click="openStatusModal()" 
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
                                            <button @click="openStatusModal()" 
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
                openStatusModal() {
                    console.log("Ouverture de la modal pour la réservation", type);
                    // Ouvrir la modal avec SweetAlert2
                    Swal.fire({
                        title: 'Choisissez un statut',
                        input: 'radio',
                        inputOptions: {
                            'pending': 'En attente',
                            'validated': 'Validé',
                            'rejected': 'Rejeté'
                        },
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Vous devez choisir un statut !';
                            }
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Confirmer',
                        cancelButtonText: 'Annuler',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.status = result.value; // Mettre à jour le statut selon la sélection
                            this.handleStatusChange(id, result.value, type); // Afficher le bon formulaire
                        }
                    });
                },

                handleStatusChange(id, status, type) {
                    if (status === 'validated') {
                        this.showValidatedForm(id, type); // Affiche le formulaire pour validé
                    } else if (status === 'rejected') {
                        this.showRejectedForm(id, type); // Affiche le formulaire pour rejeté
                    } else {
                        this.updatePending(id, status, type); // Mettre à jour le statut
                        Swal.fire('Réservation mise en attente', 'Les informations ont été mises à jour avec succès', 'success');
                    }
                },

                updatePending(reservationId, status, type) {
                    axios.post(`/admin/reservations/${reservationId}/update-pending-${type}`, {
                        status: status
                    })
                    .then(response => {
                        // Afficher un message de succès si la mise à jour est réussie
                        console.log('Réservation mise à jour:', response.data);
                    })
                    .catch(error => {
                        // En cas d'erreur, afficher un message d'erreur
                        console.error('Erreur lors de la mise à jour du statut:', error);
                        Swal.fire('Erreur', 'Une erreur est survenue lors de la mise à jour.', 'error');
                    });
                },


                showValidatedForm(reservationId, type) {
                    Swal.fire({
                        title: 'Formulaire Validé',
                        html: `
                            <label for="price">Prix:</label>
                            <input type="number" id="price" class="swal2-input" placeholder="Prix">
                            <label for="notes">Notes:</label>
                            <textarea id="notes" class="swal2-input" placeholder="Notes"></textarea>
                        `,
                        confirmButtonText: 'Envoyer',
                        focusConfirm: false,
                        preConfirm: () => {
                            const price = document.getElementById('price').value;
                            const notes = document.getElementById('notes').value;

                            // Validation des champs
                            if (!price || !notes) {
                                Swal.showValidationMessage('Veuillez remplir tous les champs');
                                return false;
                            }

                            // Envoi des données pour mettre à jour la réservation validée
                            this.updateValidatedReservation(reservationId, type, price, notes);
                        }
                    });
                },

                // Fonction pour envoyer la mise à jour de la réservation validée
                updateValidatedReservation(reservationId, type, price, notes) {
                    axios.post(`/admin/reservations/${reservationId}/update-validated-${type}`, {
                        finded_price: price,
                        notes: notes,
                        status: 'validated',  // Le statut doit être "validé"
                    })
                    .then(response => {
                        Swal.fire('Réservation mise à jour', 'La réservation a été validée avec succès.', 'success');
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire('Erreur', 'Une erreur est survenue lors de la mise à jour.', 'error');
                    });
                },


                showRejectedForm(reservationId, type) {
                    Swal.fire({
                        title: 'Formulaire Rejeté',
                        html: `
                            <label for="finded_price">Prix trouvé:</label>
                            <input type="number" id="finded_price" class="swal2-input" placeholder="Prix trouvé">
                            <label for="finded_departure_date">Date de départ:</label>
                            <input type="date" id="finded_departure_date" class="swal2-input" placeholder="Date de départ">
                            <label for="finded_return_date">Date de retour:</label>
                            <input type="date" id="finded_return_date" class="swal2-input" placeholder="Date de retour">
                            <label for="notes">Notes:</label>
                            <textarea id="notes" class="swal2-input" placeholder="Notes"></textarea>
                        `,
                        confirmButtonText: 'Envoyer',
                        focusConfirm: false,
                        preConfirm: () => {
                            const finded_price = document.getElementById('finded_price').value;
                            const finded_departure_date = document.getElementById('finded_departure_date').value;
                            const finded_return_date = document.getElementById('finded_return_date').value;
                            const notes = document.getElementById('notes').value;

                            // Envoie les données au serveur pour mettre à jour la réservation
                            axios.post(`/admin/reservations/${reservationId}/update-rejected-${type}`, {
                                finded_price,
                                finded_departure_date,
                                finded_return_date,
                                notes
                            })
                            .then(response => {
                                if (response.data.success) {
                                    Swal.fire('Réservation rejetée', 'Les informations ont été mises à jour avec succès', 'success');
                                } else {
                                    Swal.fire('Erreur', response.data.error || 'Une erreur est survenue lors de la mise à jour.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Erreur lors de la mise à jour:', error);
                                Swal.fire('Erreur', 'Une erreur est survenue lors de la mise à jour.', 'error');
                            });
                        }
                    });
                }
            }));

        });
    </script>
        
    @endsection
    