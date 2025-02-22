<header class="header header-sticky">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">

            <x-coreui-icon class="icon icon-lg" icon="cil-menu" />
        </button>

        <a class="header-brand d-md-none" href="#">
            <div width="118" height="46" alt="CoreUI Logo">
                <img src="{{ asset('assets/img/logo.png') }}" width="150" height="auto" />
            </div>
        </a>

        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#"
                    role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <!-- <img class="avatar-img"  src="{{ asset('assets/img/logo.png') }}"
                            alt="{{ auth()->User()->email }}"> -->
                            <img class="avatar-img"  src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png"
                            alt="{{ auth()->User()->email }}">
                    </div>
                    <span>{{ auth()->User()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Mon Compte</div>
                    </div>

                    <a class="dropdown-item" href="{{route('admin.profile.edit')}}">

                        <x-coreui-icon class="icon me-2" icon="cil-user" />
                        Profil
                    </a>

                    <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    class="dropdown-item"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            <x-coreui-icon class="icon me-2" icon="cil-account-logout" />
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
   @yield('breadcrum')
</header>
