@extends('backend.layouts.app')

@section('head')
    <title>Réservations - {{ config('app.name', 'Laravel') }}</title>
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
            <h2 class="mb-4">Réservations (<span x-text="typeReservationModel"></span>)</h2>

            <!-- TABLEAU DES VOLS -->
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
                            <template x-for="(reservation, index) in reservations.data" :key="reservation.id">
                                <tr class="align-middle">
                                    <td class="text-center fw-bold" x-text="index + 1"></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-primary">
                                                <i class="fas fa-plane-departure"></i>
                                                <span x-text="translateTypeFlight(reservation.flight_type)"></span>
                                            </span>
                                            <hr class="my-1">
                                            <span class="fw-bold text-success">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span x-text="reservation.countries?.country ?? ''"></span> →
                                                <span x-text="reservation.destinations?.country ?? ''"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold" x-text="reservation.client?.firstname ?? ''"></span>
                                        <span x-text="reservation.client?.lastname ?? ''"></span>
                                    </td>
                                    <td x-text="reservation.client?.phone ?? ''"></td>
                                    <td x-text="formatDate(reservation.created_at)"></td>

                                    <!-- Gestion du statut avec SweetAlert2 -->
                                    <td class="text-center">
                                        <div x-data="statusManager(reservation.id, 'Flight', reservation.status)">
                                            <button @click="updateStatus()" 
                                                    class="btn btn-sm d-flex align-items-center justify-content-center" 
                                                    :class="status === 'pending' ? 'btn-warning' : (status === 'validated' ? 'btn-success' : 'btn-danger')"
                                                    :disabled="isLoading">
                                                <span x-show="!isLoading" x-text="translateStatus(status)"></span>
                                                <span x-show="isLoading">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </span>
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
                </div>
            </template>

            <!-- TABLEAU POUR LES HÔTELS -->
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
                                    <td x-text="reservation.client_id"></td>
                                    <td x-text="reservation.number_of_room"></td>
                                    <td x-text="formatDate(reservation.created_at)"></td>

                                    <!-- Gestion du statut avec SweetAlert2 -->
                                    <td class="text-center">
                                        <div x-data="statusManager(reservation.id, 'Hotel', reservation.status)">
                                            <button @click="updateStatus()" 
                                                    class="btn btn-sm d-flex align-items-center justify-content-center" 
                                                    :class="status === 'pending' ? 'btn-warning' : (status === 'validated' ? 'btn-success' : 'btn-danger')"
                                                    :disabled="isLoading">
                                                <span x-show="!isLoading" x-text="translateStatus(status)"></span>
                                                <span x-show="isLoading">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </template>

            <!-- TABLEAU POUR LES LOCATIONS DE VOITURES -->
            <template x-if="typeReservationModel === 'locations'">
                <div>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Age</th>
                                <th>Date de la demande</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="reservation in reservations.data" :key="reservation.id">
                                <tr>
                                    <td x-text="reservation.id"></td>
                                    <td x-text="reservation.client?.firstname + ' ' + reservation.client?.lastname"></td>
                                    <td x-text="reservation.age"></td>
                                    <td x-text="formatDate(reservation.created_at)"></td>

                                    <!-- Gestion du statut avec SweetAlert2 -->
                                    <td class="text-center">
                                        <div x-data="statusManager(reservation.id, 'CarLocation', reservation.status)">
                                            <button @click="updateStatus()" 
                                                    class="btn btn-sm d-flex align-items-center justify-content-center" 
                                                    :class="status === 'pending' ? 'btn-warning' : (status === 'validated' ? 'btn-success' : 'btn-danger')"
                                                    :disabled="isLoading">
                                                <span x-show="!isLoading" x-text="translateStatus(status)"></span>
                                                <span x-show="isLoading">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </template>

        </div>
    </div>
    <script>
        
        document.addEventListener('alpine:init', () => {
            
            const appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');

            // Gestion des réservations
            Alpine.data('reservationTable', () => ({
                reservations: { data: [], total: 0, per_page: 5, current_page: 1, last_page: 1 },
                typeReservationModel: 'vols',
                baseUrl: `${appUrl}/admin/reservations/`,
    
                init() {
                    console.log("Initialisation du composant...");
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
                        locations: `${this.baseUrl}fetchLocations`
                    };
                    return endpoints[this.typeReservationModel] || this.baseUrl;
                },
    
                fetchReservationsForType() {
                    const endpoint = this.getApiEndpoint();
                    if (!endpoint) {
                        console.error("Endpoint introuvable :", this.typeReservationModel);
                        return;
                    }
                    this.fetchReservations(endpoint);
                },
    
                fetchReservations(url) {
                    console.log("Appel API :", url);
    
                    axios.get(url, {
                        params: { page: this.reservations.current_page, per_page: this.reservations.per_page }
                    })
                    .then(response => {
                        this.reservations = response.data;
                    })
                    .catch(error => {
                        console.error("Erreur lors du chargement :", error);
                        Swal.fire("Erreur", "Impossible de charger les réservations.", "error");
                    });
                },

                supprimerReservation(type, id) {
                    Swal.fire({
                        title: "Êtes-vous sûr ?",
                        text: "Cette action est irréversible !",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Oui, supprimer",
                        cancelButtonText: "Annuler",
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = `${appUrl}/admin/reservations/delete/${type}/${id}`;

                            Swal.fire({
                                title: "Suppression en cours...",
                                text: "Veuillez patienter",
                                icon: "info",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            axios.delete(url, {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(() => {
                                Swal.fire("Supprimé!", "La réservation a été supprimée avec succès.", "success");
                                this.fetchReservationsForType();
                            })
                            .catch(error => {
                                console.error("Erreur lors de la suppression :", error);
                                Swal.fire("Erreur", "Une erreur est survenue lors de la suppression.", "error");
                            });
                        }
                    });
                },

                voirReservation(client_id, reservation_id) {
                    console.log('APP URL: ', appUrl);
                    window.location.href = `${appUrl}/admin/reservations/${client_id}/${reservation_id}`;
                },
    
                jumpToPage(page) {
                    this.reservations.current_page = page;
                    this.fetchReservationsForType();
                },
    
                formatDate(dateString) {
                    if (!dateString) return "Non disponible";
                    return new Date(dateString).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
                },

                // Traduction des types de vol en français
                translateTypeFlight(flightType) {
                    return flightType === 'one-way' ? 'Aller simple' :
                        flightType === 'round-trip' ? 'Aller-retour' :
                        flightType === 'multi-city' ? 'Multi-destinations' : 'Inconnu';
                }
            }));
    
            // Gestion des statuts avec SweetAlert2
            Alpine.data('statusManager', (id, type, initialStatus) => ({
                id,
                type,
                status: initialStatus,
                isLoading: false,

                translateStatus(status) {
                    return status === 'pending' ? 'En attente' :
                        status === 'validated' ? 'Validé' :
                        status === 'rejected' ? 'Rejeté' : 'Inconnu';
                },
    
                updateStatus() {
                    Swal.fire({
                        title: "Modifier le statut",
                        text: "Sélectionnez le nouveau statut :",
                        icon: "question",
                        input: "select",
                        inputOptions: {
                            pending: "En attente",
                            validated: "Validé",
                            rejected: "Rejeté"
                        },
                        inputValue: this.status,
                        showCancelButton: true,
                        confirmButtonText: "Confirmer",
                        cancelButtonText: "Annuler"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.confirmStatusChange(result.value);
                        }
                    });
                },
    
                confirmStatusChange(newStatus) {
                    let endpoint = `${appUrl}/admin/reservations/${this.id}/update-status-${this.type.toLowerCase()}`;
    
                    console.log("API appelée:", endpoint);
                    this.isLoading = true;
    
                    axios.post(endpoint, { status: newStatus }, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.status = newStatus;
                            Swal.fire("Succès", "Le statut a été mis à jour avec succès.", "success");
                        } else {
                            Swal.fire("Erreur", "Échec de la mise à jour du statut.", "error");
                        }
                    })
                    .catch(error => {
                        console.error("Erreur réseau:", error);
                        Swal.fire("Erreur", "Une erreur est survenue lors de la mise à jour du statut.", "error");
                    })
                    .finally(() => {
                    this.isLoading = false;
                    });
                }
            }));
        });
    </script>
    
@endsection
