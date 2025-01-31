@extends('backend.layouts.app')


@section('head')
<title>Reservations - Amazone Tchad Admin</title>
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Accueil</span>
            </li>
            <li class="breadcrumb-item active"><span>Reservations</span></li>

        </ol>
    </nav>
</div>
@endsection

@section('content')

    <select name="typeReservation" x-model="typeReservationModel" id="typeReservation">
        <option value="vols">vols</option>
        <option value="hotels">hotels</option>
        <option value="volshotels">vols + hotels</option>
        <option value="locations">Locations de voitures</option>
    </select>

    <div class="container mt-5" x-data="reservationTable">

        <h2 class="mb-4">Réservations ( <span x-text="typeReservationModel"></span> )</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Type</th>
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
                        <td x-text="reservation.client"></td>
                        <td x-text="reservation.phone"></td>
                        <td x-text="reservation.created_at"></td>
                        <td>
                            <span class="badge" :class="reservation.status === 'pendding' ? 'bg-success' : 'bg-danger'" x-text="reservation.status"></span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm">
                                voir
                            </a>
                            <button class="btn btn-danger btn-sm" @click="supprimerReservation(reservation.id)">
                                supprimer
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
        <!-- pagination -->
        <nav>
            <ul class="pagination">
                <li class="page-item" :class="{ 'disabled': !reservations.prev_page_url }">
                    <button class="page-link" @click="fetchReservations(reservations.prev_page_url)">Précédent</button>
                </li>
                <template x-for="page in totalPages" :key="page">
                    <li class="page-item" :class="{ 'active': reservations.current_page === page }">
                        <button class="page-link" @click="fetchReservations(`/reservations/fetch?page=${page}`)" x-text="page"></button>
                    </li>
                </template>
                <li class="page-item" :class="{ 'disabled': !reservations.next_page_url }">
                    <button class="page-link" @click="fetchReservations(reservations.next_page_url)">Suivant</button>
                </li>
            </ul>
        </nav>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('ReservationTable', () => ({
                reservations: { data: [], total: 0, per_page: 10, current_page: 1, last_page: 1 },
                totalPages: 1,

                init () {
                    this.fetchReservations('/reservations/fetch');
                },

                fetchReservations (url) {
                    axios.get(url)
                        .then(response => {
                            this.reservations = response.data;
                            this.totalPages = this.reservations.last_page;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },

                supprimerReservation (id) {
                        if (!confirm('Voulez-vous vraiment supprimer ce reservation ?')) return;
                        axios.delete(`/reservations/delete/${id}`)
                            .then(() => {
                                this.fetchReservations(`/reservations/fetch?page=${this.reservations.current_page}`);
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
            }));
        });
    </script>
@endsection