<x-guest-layout>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4 mx-4">
                        <div class="card-body p-4">
                            <h1>Mot de passe oublié ?</h1>

                            <p class="text-medium-emphasis">
                                {{ __('Pas de problème. Il suffit de nous indiquer votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe qui vous permettra d\'en choisir un nouveau.') }}
                            </p>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4 alert-info" :status="session('status')" />

                            <form method="POST" action="{{ route('password.email') }}"
                                class="needs-validation" novalidate>
                                @csrf

                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Adresse e-mail')" />
                                    <x-text-input id="email" class="form-control mt-1 w-full" type="email"
                                        name="email" :value="old('email')" required autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="btn btn-success">
                                        {{ __('Envoyer le lien de réinitialisation du mot de passe') }}
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

