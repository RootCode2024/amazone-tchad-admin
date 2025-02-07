@extends('backend.layouts.app')

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <span>Accueil</span>
            </li>
            <li class="breadcrumb-item active"><span>Profil</span></li>
        </ol>
    </nav>
</div>
@endsection

@section('content')

<!-- Section Profil -->
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Mise à jour des infos -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-primary">Informations du Profil</h5>
                    @include('backend.profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Mise à jour du mot de passe -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-primary">Modifier le Mot de Passe</h5>
                    @include('backend.profile.partials.update-password-form')
                </div>
            </div>

            <!-- Suppression du compte -->
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-danger">Supprimer le Compte</h5>
                    @include('backend.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles améliorés -->
<style>
    .card {
        transition: all 0.3s ease-in-out;
    }

    .container{
        width: 100% !important;
    }

    .card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h5 {
        font-size: 1.3rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h5 {
            font-size: 1.1rem;
        }

        .card-body {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        h5 {
            font-size: 1rem;
        }

        .container {
            padding: 0 15px;
        }

        .card-body {
            padding: 15px;
        }
    }
</style>

@endsection
