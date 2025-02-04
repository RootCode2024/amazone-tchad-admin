@extends('backend.layouts.app')

@section('title', 'Tableau de bord - Amazone Tchad Admin')

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Accueil</span>
            </li>
            <li class="breadcrumb-item active"><span>Utilisateurs</span></li>

        </ol>
    </nav>
</div>
@endsection

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-8 text-center">
                <h1 class="display-8 fw-bold">Liste des Administrateurs & Managers</h1>
            </div>
        </div>
    </div>
</section>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nom Complet</th>
            <th>Role</th>
            <th>Email</th>
            <th>Compte vérifié</th>
            <th>Créé le</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
            <td>{{ $loop->index+1 }}</td>
            <td>
                {{ $user->name }}
                @if ($user->email === auth()->user()->email)
                    <span class="p-1 rounded bg-success">(VOUS)</span>
                @endif
            </td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->email_verified_at ?? 'Non Vérifié' }}</td>
            <td>{{ $user->created_at }}</td>
            @if(auth()->user()->role === 'admin')
            <td>
                <a class="#">
                    <x-coreui-icon class="nav-icon" icon="cil-trash" style="width: 15px;height:15px;color:red;" />
                </a>                            
            </td>
            @endif
        </tr>
        @endforeach
        
    </tbody>
</table>

@endsection