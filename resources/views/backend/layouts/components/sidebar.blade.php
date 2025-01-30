<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">
            <x-coreui-icon class="nav-icon" icon="cil-speedometer" />
            Tableau de Bord
            <span class="badge badge-sm bg-info ms-auto">Nouveau</span></a></li>

        <li class="nav-title">Profil Manager</li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <x-coreui-icon class="nav-icon" icon="cil-user" />
                Profil 
            </a>
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.profile.edit') }}">
                        <x-coreui-icon class="nav-icon" icon="cil-pen" />
                        Editer
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-title">Clients Managment</li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <x-coreui-icon class="nav-icon" icon="cil-user" />
                Clients 
            </a>
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.profile.edit') }}">
                        <x-coreui-icon class="nav-icon" icon="cil-pen" />
                        Liste
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.profile.edit') }}">
                        <x-coreui-icon class="nav-icon" icon="cil-pen" />
                        Corbeille
                    </a>
                </li>
            </ul>
        </li>

    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
