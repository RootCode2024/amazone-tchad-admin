<x-guest-layout>
    <!-- Session Status -->
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <!-- Formulaire de connexion admin -->
                        <div class="card col-md-7 p-4 mb-0">
                            <div class="card-body">
                                <h1>Connexion Admin</h1>
                                <p class="text-medium-emphasis">
                                    Connectez-vous à l'administration de Amazone Tchad
                                </p>

                                <x-auth-session-status class="mb-4 alert-info" :status="session('status')" />

                                <!-- Formulaire de connexion -->
                                <form method="POST" action="{{ route('login') }}" class="was-validated needs-validation" novalidate>
                                    @csrf

                                    <!-- Champ Email -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="{{ asset('assets/icons/sprites/free.svg') }}#cil-user"></use>
                                            </svg>
                                        </span>
                                        <x-text-input
                                            id="email"
                                            class="form-control"
                                            type="email"
                                            name="email"
                                            :value="old('email')"
                                            required
                                            autofocus
                                            autocomplete="username"
                                            placeholder="admin@amazone-tchad.td" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2 d-block" />
                                    </div>

                                    <!-- Champ Mot de passe -->
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="{{ asset('assets/icons/sprites/free.svg') }}#cil-lock-locked"></use>
                                            </svg>
                                        </span>
                                        <x-text-input
                                            id="password"
                                            class="form-control"
                                            type="password"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                            placeholder="Mot de passe" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2 d-block" />
                                    </div>

                                    <!-- Se souvenir de moi -->
                                    <div class="block mb-3">
                                        <label for="remember_me" class="inline-flex items-center">
                                            <input id="remember_me" type="checkbox"
                                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                                name="remember">
                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                Se souvenir de moi
                                            </span>
                                        </label>
                                    </div>

                                    <!-- Boutons -->
                                    <div class="row">
                                        <div class="col-6">
                                            <x-primary-button class="btn btn-primary px-4">
                                                Connexion
                                            </x-primary-button>
                                        </div>
                                        <div class="col-6 text-end">
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                                    Mot de passe oublié ?
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Informations complémentaires -->
                        <div class="card col-md-5 text-white bg-primary py-5">
                            <div class="card-body text-center">
                                <div>
                                    <h2>Besoin d'un compte admin ?</h2>
                                    <p>
                                        Si vous n'avez pas encore de compte administrateur, merci de contacter
                                        le super administrateur de Amazone Tchad.
                                    </p>
                                    <!-- En général, l'inscription pour l'administration est réservée -->
                                    
                                    @if (Route::has('register'))
                                        <a class="btn btn-lg btn-outline-light mt-3" href="{{ route('register') }}">
                                            S'inscrire
                                        </a>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Fin informations complémentaires -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
