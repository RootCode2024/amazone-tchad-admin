@extends('backend.layouts.app')

@section('head')
<title>Clients - {{ config('app.name', 'Laravel') }}</title>
<meta name="app-url" content="{{ config('app.url') }}">
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <span>Accueil</span>
            </li>
            <li class="breadcrumb-item active"><span>Clients</span></li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container mt-5" x-data="clientTable">
    <h2 class="fw-bold text-primary mb-4">Clients</h2>

    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Liste des Clients</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-responsive-lg text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom Complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Type de réservation</th>
                        <th>Demandé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-if="isLoading">
                        <tr>
                            <td colspan="7" class="text-center py-3">
                                <span class="spinner-border spinner-border-sm"></span> Chargement...
                            </td>
                        </tr>
                    </template>

                    <template x-for="(client, index) in clients.data" :key="client?.id">
                        <tr>
                            <td x-text="index + 1"></td>
                            <td class="fw-bold">
                                <span x-text="client.firstname"></span>
                                <span x-text="client.lastname"></span>
                            </td>
                            <td x-text="client.email"></td>
                            <td x-text="client.phone"></td>
                            <td>
                                <span class="badge bg-primary" 
                                      x-text="translateReservationType(client.type_of_reservation)">
                                </span>
                            </td>
                            <td x-text="formatDate(client.created_at)"></td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger mx-1" @click="supprimerClient(client.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <a :href="`${appUrl}/admin/client/${client.id}`" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ 'disabled': !clients.prev_page_url }">
                <button class="page-link" @click="fetchClients(clients.prev_page_url)">
                    <i class="fas fa-chevron-left"></i> Précédent
                </button>
            </li>
            <template x-for="page in totalPages" :key="page">
                <li class="page-item" :class="{ 'active': clients.current_page === page }">
                    <button class="page-link" @click="fetchClients(`${appUrl}/admin/clients/fetch?page=${page}`)" x-text="page"></button>
                </li>
            </template>
            <li class="page-item" :class="{ 'disabled': !clients.next_page_url }">
                <button class="page-link" @click="fetchClients(clients.next_page_url)">
                    Suivant <i class="fas fa-chevron-right"></i>
                </button>
            </li>
        </ul>
    </nav>
</div>

<style>
    .card {
        border-radius: 12px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    }

    .card:hover {
        transform: scale(1.02);
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    }

    .badge {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 8px;
    }

    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        
        const appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');
            Alpine.data('clientTable', () => ({
                appUrl, 
                clients: { data: [], total: 0, per_page: 10, current_page: 1, last_page: 1, prev_page_url: null, next_page_url: null },
                totalPages: 1,
                isLoading: true, 

                init () {
                    this.fetchClients(`${appUrl}/admin/clients/fetch`);
                },

                fetchClients (url) {
                    this.isLoading;
                    axios.get(url)
                        .then(response => {
                            this.clients = response.data;
                            this.totalPages = this.clients.last_page;
                            console.log(this.clients);
                        })
                        .catch(error => {
                            console.error("Erreur de récupération des clients :", error);
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                },

                supprimerClient (id) {
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
                            let url = `${this.appUrl}/admin/clients/delete/${id}`;

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

                            axios.delete(url)
                                .then(() => {
                                    Swal.fire("Supprimé!", "Le client a été supprimé avec succès.", "success");
                                    this.fetchClients(`${this.appUrl}/admin/clients/fetch?page=${this.clients.current_page}`);
                                })
                                .catch(error => {
                                    console.error("Erreur de suppression :", error);
                                    Swal.fire("Erreur", "Une erreur est survenue lors de la suppression.", "error");
                                });
                        }
                    });
                },

                formatDate(dateString) {
                    return new Date(dateString).toLocaleString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
                },

                translateReservationType(type) {
                    return type === 'car_location' ? 'Location de voiture' :
                           type === 'flight' ? 'Vol' :
                           type === 'hotel' ? 'Hôtel' : 'Vol + Hôtel';
                },
            }));
        });
</script>
@endsection
