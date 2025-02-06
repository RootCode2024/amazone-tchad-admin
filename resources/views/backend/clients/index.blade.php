@extends('backend.layouts.app')


@section('head')
<title>Clients - {{ config('app.name', 'Laravel') }}</title>
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Accueil</span>
            </li>
            <li class="breadcrumb-item active"><span>Clients</span></li>

        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container mt-5" x-data="clientTable">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Clients</h2>
    </div>

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
                    <template x-for="client in clients.data" :key="client?.id">
                        <tr>
                            <td x-text="clients.data.indexOf(client) + 1"></td>
                            <td class="fw-bold">
                                <span x-text="client.firstname"></span>
                                <span x-text="client.lastname"></span>
                            </td>
                            <td x-text="client.email"></td>
                            <td x-text="client.phone"></td>
                            <td>
                                <span class="badge bg-primary" 
                                      x-text="client.type_of_reservation === 'car_location' ? 'Location de voiture' : 
                                              (client.type_of_reservation === 'flight' ? 'Vol' : 
                                              (client.type_of_reservation === 'hotel' ? 'Hôtel' : 'Vol + Hôtel'))">
                                </span>
                            </td>
                            <td x-text="new Date(client.created_at).toLocaleString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })"></td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger mx-1" @click="supprimerClient(client.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <a :href="`${window.location.origin}/admin/client/${client.id}`" class="btn btn-sm btn-outline-primary">
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
                    <button class="page-link" @click="fetchClients(`/clients/fetch?page=${page}`)" x-text="page"></button>
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
        Alpine.data('clientTable', () => ({
            clients: { data: [], total: 0, per_page: 10, current_page: 1, last_page: 1 },
            totalPages: 1,

            init () {
                this.fetchClients(`${window.location.origin}/admin/clients/fetch`);
            },

            fetchClients (url) {
                axios.get(url)
                    .then(response => {
                        this.clients = response.data;
                        this.totalPages = this.clients.last_page;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },

            supprimerClient (id) {
                    if (!confirm('Voulez-vous vraiment supprimer ce client ?')) return;
                    axios.delete(`${window.location.origin}/admin/clients/delete/${id}`)
                        .then(() => {
                            this.fetchClients(`${window.location.origin}/admin/clients/fetch?page=${this.clients.current_page}`);
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
        }));
    });
</script>
@endsection