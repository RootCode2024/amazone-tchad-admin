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
<section class="py-3 bg-gradient-primary text-white text-center">
    <div class="container">
        <h1 class="fw-bold">Gestion des Administrateurs & Managers</h1>
        <p class="lead">Gérez les utilisateurs avec des rôles spécifiques pour assurer la gestion de votre plateforme.</p>
    </div>
</section>

<!-- Tableau des utilisateurs -->
<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des Utilisateurs</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
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
</div>

<!-- Style amélioré avec gestion des polices -->
<style>
    /* Section en-tête */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #5c6bc0 0%, #7986cb 100%);
        padding: 25px 0;
    }

    /* Cartes et animations */
    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s;
        border-radius: 12px;
    }

    .card:hover {
        transform: scale(1.01);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Polices */
    h1 {
        font-size: 2rem;
    }

    h5 {
        font-size: 1.3rem;
    }

    .lead {
        font-size: 1rem;
    }

    .table th, .table td {
        vertical-align: middle;
        white-space: nowrap;
        font-size: 1rem;
    }

    /* Badges et boutons */
    .badge {
        padding: 6px 10px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 8px;
    }

    .btn {
        font-size: 14px;
        padding: 6px 10px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        h1 {
            font-size: 1.5rem;
        }

        h5 {
            font-size: 1rem;
        }

        .lead {
            font-size: 0.95rem;
        }

        .table th, .table td {
            font-size: 0.9rem;
            padding: 8px;
        }

        .btn {
            font-size: 12px;
            padding: 5px 8px;
        }
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 1.2rem;
        }

        h5 {
            font-size: 0.9rem;
        }

        .lead {
            font-size: 0.9rem;
        }

        .table th, .table td {
            font-size: 0.85rem;
            padding: 6px;
        }

        .btn {
            font-size: 12px;
            padding: 5px 8px;
        }
    }

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

        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .table tbody tr td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 0.8rem;
        }

        .table tbody tr td:last-child {
            border-bottom: none;
        }

        .btn {
            width: 100%;
        }
    }

</style>

@endsection
