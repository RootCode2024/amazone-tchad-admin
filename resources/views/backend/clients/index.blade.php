@extends('backend.layouts.app')


@section('head')
<title>Clients - Amazone Tchad Admin</title>
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
        <h2 class="mb-4">Clients</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="client in clients.data" :key="client.id">
                    <tr>
                        <td x-text="client.id"></td>
                        <td x-text="client.name"></td>
                        <td x-text="client.email"></td>
                        <td x-text="client.phone"></td>
                        <td x-text="client.type"></td>
                        <td x-text="client.date"></td>
                        <td>
                            <span class="badge" :class="client.status === 'pendding' ? 'bg-success' : 'bg-danger'" x-text="client.status"></span>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm" @click="supprimerClient(client.id)">
                                Corbeille
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
        <!-- pagination -->
        <nav>
            <ul class="pagination">
                <li class="page-item" :class="{ 'disabled': !clients.prev_page_url }">
                    <button class="page-link" @click="fetchClients(clients.prev_page_url)">Précédent</button>
                </li>
                <template x-for="page in totalPages" :key="page">
                    <li class="page-item" :class="{ 'active': clients.current_page === page }">
                        <button class="page-link" @click="fetchClients(`/clients/fetch?page=${page}`)" x-text="page"></button>
                    </li>
                </template>
                <li class="page-item" :class="{ 'disabled': !clients.next_page_url }">
                    <button class="page-link" @click="fetchClients(clients.next_page_url)">Suivant</button>
                </li>
            </ul>
        </nav>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('clientTable', () => ({
                clients: { data: [], total: 0, per_page: 10, current_page: 1, last_page: 1 },
                totalPages: 1,

                init () {
                    this.fetchClients('/clients/fetch');
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
                        axios.delete(`/clients/delete/${id}`)
                            .then(() => {
                                this.fetchClients(`/clients/fetch?page=${this.clients.current_page}`);
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
            }));
        });
    </script>
@endsection