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
                    <th>Type de reservation</th>
                    <th>Demandé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="client in clients.data" :key="client?.id">
                    <tr>
                        <td x-text="clients.data.indexOf(client) + 1"></td>
                        <td>
                            <span x-text="client.firstname"></span>
                            <span x-text="client.lastname"></span>
                        </td>
                        <td x-text="client.email"></td>
                        <td x-text="client.phone"></td>
                        <td>
                            <span x-text="client.type_of_reservation === 'car_location' ? 'Location de voiture' : 
                            (client.type_of_reservation === 'flight' ? 'Vol' : 
                            (client.type_of_reservation === 'hotel' ? 'Hôtel' : 'Vol + Hôtel'))"></span>
                        </td>
                        <td x-text="new Date(client.created_at).toLocaleString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })"></td>
                        <td>
                            <a class="" @click="supprimerClient(client.id)">
                                <x-coreui-icon class="nav-icon" icon="cil-trash" style="width: 15px;height:15px;color:red;" />
                            </a>
                            <a :href="'/admin/client/' + client.id">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="15" height="15">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>                            
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
                    this.fetchClients('/admin/clients/fetch');
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
                        axios.delete(`/admin/clients/delete/${id}`)
                            .then(() => {
                                this.fetchClients(`/admin/clients/fetch?page=${this.clients.current_page}`);
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
            }));
        });
    </script>
@endsection