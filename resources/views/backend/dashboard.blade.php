@extends('backend.layouts.app')

@section('title', 'Tableau de bord - Amazone Tchad Admin')

@section('head')
    <title>Tableau de Bord - {{ config('app.name', 'Laravel') }}</title>
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Accueil</span>
            </li>
            <li class="breadcrumb-item active"><span>Tableau de Bord</span></li>

        </ol>
    </nav>
</div>
@endsection

@section('content')
<style>
    .bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
    }

    .card {
        border-radius: 12px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        text-align: center;
    }

    h5.card-title {
        font-weight: 600;
        margin-bottom: 8px;
    }

    p.mb-0 {
        font-size: 14px;
    }

    .animate__fadeInUp {
        animation: fadeInUp 0.8s ease-out;
    }

    @media (max-width: 768px) {
        .display-6 {
            font-size: 24px;
        }
        
        .card {
            margin-bottom: 15px;
        }
    }
</style>
<div class="row">
    <!-- Message de bienvenue -->
    <div class="col-12 my-3">
        <section class="py-5 bg-gradient-primary text-white text-center rounded shadow-sm">
            <div class="container">
                <h1 class="display-6 fw-bold">Heureux de vous revoir, {{ auth()->user()->name }} 👋</h1>
                <p class="lead">Bienvenue sur votre tableau de bord. Consultez les nouvelles réservations et gérez vos clients facilement.</p>
                <a href="{{ route('clients.index') }}" class="btn btn-light btn-md mt-3 fw-bold">Voir Nouveaux Clients</a>
            </div>
        </section>
    </div>

    <!-- Cartes de statistiques -->
    <div class="col-md-6 col-lg-3">
        <div class="card bg-primary text-white shadow-sm p-3 animate__animated animate__fadeInUp">
            <div class="card-body">
                <h5 class="card-title">Administrateurs & Managers</h5>
                <p class="fs-3 fw-bold">{{ $users }}</p>
                <p class="mb-0"><i class="fas fa-user-tie"></i> Gestionnaires enregistrés</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card bg-warning text-white shadow-sm p-3 animate__animated animate__fadeInUp">
            <div class="card-body">
                <h5 class="card-title">Liste des clients enregistrés</h5>
                <p class="fs-3 fw-bold">{{ $clients }}</p>
                <p class="mb-0"><i class="fas fa-users"></i> Nombre total de clients</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card bg-danger text-white shadow-sm p-3 animate__animated animate__fadeInUp">
            <div class="card-body">
                <h5 class="card-title">Réservations en attente</h5>
                <p class="fs-3 fw-bold">{{ $reservationsPendding }}</p>
                <p class="mb-0"><i class="fas fa-clock"></i> Besoin de validation</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card bg-success text-white shadow-sm p-3 animate__animated animate__fadeInUp">
            <div class="card-body">
                <h5 class="card-title">Réservations Validées</h5>
                <p class="fs-3 fw-bold">{{ $reservations }}</p>
                <p class="mb-0"><i class="fas fa-check-circle"></i> Réservations confirmées</p>
            </div>
        </div>
    </div>
</div>

@endsection
