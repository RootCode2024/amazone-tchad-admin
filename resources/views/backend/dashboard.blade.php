@extends('backend.layouts.app')

@section('title', 'Tableau de bord - Amazone Tchad Admin')

@section('head')
    <title>Tableau de Bord - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item"><span>Accueil</span></li>
            <li class="breadcrumb-item active"><span>Tableau de Bord</span></li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f4f7fc;
    }

    /* Soft, calming gradient for the header */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #5c6bc0 0%, #7986cb 100%);
    }

    /* Cards design */
    .card {
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    /* Soft hover effect */
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        text-align: center;
        padding: 20px;
    }

    h5.card-title {
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.2rem;
        color: #333;
    }

    p.mb-0 {
        font-size: 14px;
        color: #666;
    }

    .fs-3 {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
    }

    .animate__fadeInUp {
        animation: fadeInUp 0.8s ease-out;
    }

    /* Responsive Typography */
    @media (max-width: 768px) {
        .display-6 {
            font-size: 28px;
        }

        h1 {
            font-size: 1.5rem;
        }

        h5 {
            font-size: 1rem;
        }

        .lead {
            font-size: 0.95rem;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.1rem;
        }

        .fs-3 {
            font-size: 1.8rem;
        }
    }

    /* Default styles for columns */
    .col-md-6, .col-lg-3 {
        padding: 10px;
    }

    /* Mobile view (max-width: 576px) */
    @media (max-width: 576px) {
        h1 {
            font-size: 0.8rem;
        }

        h5 {
            font-size: 0.5rem;
        }

        .lead {
            font-size: 0.85rem;
        }
        .col-12 {
            padding: 10px;
        }

        .col-md-6, .col-lg-3 {
            flex: 0 0 100%; /* Cards will stack on top of each other */
            max-width: 100%;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .fs-3 {
            font-size: 1.5rem;
        }
    }

    /* Tablet view (min-width: 577px and max-width: 992px) */
    @media (min-width: 577px) and (max-width: 992px) {
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-lg-3 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    /* Desktop view (min-width: 993px) */
    @media (min-width: 993px) {
        .col-md-6, .col-lg-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }
</style>
<div class="row">
    <!-- Message de bienvenue -->
    <div class="col-12 my-3">
        <section class="py-3 bg-gradient-primary text-white text-center rounded shadow-sm">
            <div class="container">
                <h1 class="display-6 fw-bold">Heureux de vous revoir, {{ auth()->user()->name }} 👋</h1>
                <p class="lead">Bienvenue sur votre tableau de bord. Consultez les nouvelles réservations et gérez vos clients facilement.</p>
                <a href="{{ route('clients.index') }}" class="btn btn-light btn-md mt-3 fw-bold">Voir Nouveaux Clients</a>
            </div>
        </section>
    </div>

    <!-- Cards with soft and clean design -->
    <div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card bg-light text-dark shadow-sm h-100 d-flex align-items-stretch animate__animated animate__fadeInUp">
            <div class="card-body text-center">
                <h5 class="card-title">Administrateurs & Managers</h5>
                <p class="fs-3 fw-bold">{{ $users }}</p>
                <p class="mb-0"><i class="fas fa-user-tie"></i> Gestionnaires enregistrés</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card bg-light text-dark shadow-sm h-100 d-flex align-items-stretch animate__animated animate__fadeInUp">
            <div class="card-body text-center">
                <h5 class="card-title">Liste des clients enregistrés</h5>
                <p class="fs-3 fw-bold">{{ $clients }}</p>
                <p class="mb-0"><i class="fas fa-users"></i> Nombre total de clients</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card bg-light text-dark shadow-sm h-100 d-flex align-items-stretch animate__animated animate__fadeInUp">
            <div class="card-body text-center">
                <h5 class="card-title">Réservations en attente</h5>
                <p class="fs-3 fw-bold">{{ $reservationsPendding }}</p>
                <p class="mb-0"><i class="fas fa-clock"></i> Besoin de validation</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card bg-light text-dark shadow-sm h-100 d-flex align-items-stretch animate__animated animate__fadeInUp">
            <div class="card-body text-center">
                <h5 class="card-title">Réservations Validées</h5>
                <p class="fs-3 fw-bold">{{ $reservations }}</p>
                <p class="mb-0"><i class="fas fa-check-circle"></i> Réservations confirmées</p>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
