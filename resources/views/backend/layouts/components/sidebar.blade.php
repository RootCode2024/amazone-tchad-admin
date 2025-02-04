<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <div class="sidebar-brand-full" width="118" height="46" alt="Amazone Tchad Logo">
            <img src="{{ asset('assets/img/logo.png') }}" width="150" height="auto" />
        </div>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">
            <x-coreui-icon class="nav-icon" icon="cil-speedometer" />
            Tableau de Bord</a></li>

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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.profile.edit') }}">
                        <x-coreui-icon class="nav-icon" icon="cil-trash" />
                        Corbeille
                    </a>
                </li>
            </ul>
        </li>

    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
