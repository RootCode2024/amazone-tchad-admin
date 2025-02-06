<x-guest-layout>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4 mx-4">
                        <div class="card-body p-4">
                            <h1>Changer votre mot de passe</h1>

                            <p class="text-medium-emphasis">
                                {{ __("Veuillez choisir un mot de passe fort et ne pas le partager avec qui que ce soit.") }}
                            </p>



                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4 alert-info" :status="session('status')" />

                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Adresse e-mail')" />
                                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-input-label for="password" :value="__('Mot de passe')" />
                                    <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mt-4">
                                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

                                    <x-text-input id="password_confirmation" class="form-control"
                                                        type="password"
                                                        name="password_confirmation" required autocomplete="new-password" />

                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="btn btn-success">
                                        {{ __('Réinitialiser le mot de passe') }}
                                    </x-primary-button>
                                </div>
                            </form>

                            {{-- <button class="btn btn-block btn-success" type="button">Créer un compte</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-guest-layout>

