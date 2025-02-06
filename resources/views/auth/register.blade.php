<x-guest-layout>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card mb-4 mx-4">
                <div class="card-body p-4">
                  <h1>Inscription</h1>
                  <p class="text-medium-emphasis">Créez votre compte</p>

                  <form method="POST" action="{{ route('register') }}" class="was-validated needs-validation" novalidate >
                    @csrf

                    <!-- Nom -->
                    <div>
                        <x-input-label for="name" :value="__('Nom')" />
                        <x-text-input id="name" class="form-control block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Adresse e-mail -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Adresse e-mail')" />
                        <x-text-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Mot de passe -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Mot de passe')" />

                        <x-text-input id="password" class="form-control block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirmer le mot de passe -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

                        <x-text-input id="password_confirmation" class="form-control block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>



                    <x-primary-button class="btn btn-block btn-success mt-4">
                        {{ __('S\'inscrire') }}
                    </x-primary-button>
                </form>

                <div class="mt-4">
                    <a class="block underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        {{ __('Déjà inscrit ?') }}
                    </a>
                </div>

                  {{-- <button class="btn btn-block btn-success" type="button">Create Account</button> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


</x-guest-layout>

