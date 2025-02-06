@extends('backend.layouts.app')

@section('head')
    <title>Admins & Managers - {{ config('app.name', 'Laravel') }}</title>
@endsection

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <span>Accueil</span>
            </li>
            <li class="breadcrumb-item active"><span>Utilisateurs</span></li>
        </ol>
    </nav>
</div>
@endsection

@section('content')

<!-- En-tête améliorée -->
<section class="py-5 bg-gradient-primary text-white text-center rounded shadow-sm">
    <div class="container">
        <h1 class="display-6 fw-bold">Gestion des Administrateurs & Managers</h1>
        <p class="lead">Gérez les utilisateurs avec des rôles spécifiques pour assurer la gestion de votre plateforme.</p>
    </div>
</section>

<!-- Tableau amélioré -->
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des Utilisateurs</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-responsive-lg mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Nom Complet</th>
                        <th>Rôle</th>
                        <th>Email</th>
                        <th>Compte Vérifié</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="align-middle text-center">
                            <td>{{ $loop->index+1 }}</td>
                            <td class="fw-bold">
                                {{ $user->name }}
                                @if ($user->email === auth()->user()->email)
                                    <span class="badge bg-success">VOUS</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'warning' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->email_verified_at)
                                    <span class="badge bg-success">✔ Vérifié</span>
                                @else
                                    <span class="badge bg-danger">✖ Non Vérifié</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            @if(auth()->user()->role === 'admin')
                            <td>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
        padding: 30px 0;
    }

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
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

</style>
@endsection
