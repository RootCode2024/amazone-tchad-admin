<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <a href="{{ route('dashboard') }}">    
            <div class="sidebar-brand-full" width="118" height="46" alt="Amazone Tchad Logo">
                <img src="{{ asset('assets/img/logo.png') }}" width="150" height="auto" />
            </div>
        </a>
        <a href="{{ route('dashboard') }}">
            <div class="sidebar-brand-narrow" width="46" height="46" alt="Amazone Tchad Logo">
                <img src="{{ asset('assets/img/logo.png') }}" width="46" height="auto" />
            </div>
        </a>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">
            <x-coreui-icon class="nav-icon" icon="cil-speedometer" />
            Tableau de Bord</a>
        </li>

        <li class="">
            <a class="nav-link nav-group-toggle fw-bold text-light" href="#">
                Clients & Reservations
            </a>
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clients.index') }}">
                        <x-coreui-icon class="nav-icon" icon="cil-people" />
                        Liste clients
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('reservations.index') }}">
                        <x-coreui-icon class="nav-icon" icon="cil-list" />
                        Liste reservations
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item"><a class="nav-link" href="{{ route('users') }}">
            <x-coreui-icon class="nav-icon" icon="cil-people" />
            Utilisateurs</a>
        </li>

    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>

<style>
    /* Sidebar background color */
    .sidebar {
        background-color: #343a40;
    }

    /* Sidebar links */
    .sidebar-nav .nav-link {
        color: #ccc;
        font-size: 1rem;
        padding: 12px 15px;
        border-radius: 8px;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Sidebar hover effect */
    .sidebar-nav .nav-link:hover {
        background-color: #495057;
        color: #fff;
    }

    /* Active link */
    .sidebar-nav .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }

    /* Sidebar group header (Clients & Reservations) */
    .nav-group-toggle {
        color: #bbb;
        font-weight: 600;
        padding: 12px 15px;
        background-color: #495057;
        border-top: 1px solid #444;
        transition: background-color 0.3s;
    }

    .nav-group-items {
        padding-left: 20px;
    }

    /* Sidebar icons */
    .nav-icon {
        font-size: 1.2rem;
        color: #adb5bd;
    }

    .nav-item .nav-link span.ms-2 {
        margin-left: 10px;
    }

    /* Sidebar toggler */
    .sidebar-toggler {
        background-color: #343a40;
        border: none;
    }

    /* Make the sidebar responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 240px;
            transition: width 0.3s;
        }

        .sidebar-nav .nav-link {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .sidebar-nav .nav-group-toggle {
            font-size: 0.95rem;
            padding: 10px 15px;
        }

        .sidebar-brand-full img,
        .sidebar-brand-narrow img {
            width: 120px;
        }
    }
</style>
