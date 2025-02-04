<x-guest-layout>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4 mx-4">
                        <div class="card-body p-4">



                            <div class="mt-4 flex items-center justify-between">
                                <form method="POST" action="{{ route('verification.send') }}" class="text-center">

                                    <x-coreui-icon class="icon"
                                        style="width: 100px;height: 100px;margin: 0px auto;text-align: center;display: block;"
                                        icon="cil-envelope-closed" />

                                    <div class="my-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Merci de vous  être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer par e-mail ? Si vous n avez pas reçu l e-mail, nous serons ravis de vous en envoyer un autre.') }}
                                    </div>

                                    @if (session('status') == 'verification-link-sent')
                                        @php
                                            $msg = __('Un nouveau lien de vérification a  été envoyé sur l adresse e-mail que vous avez fournie lors de l inscription.');
                                        @endphp
                                        <x-auth-session-status class="mb-4 alert-info" :status="$msg" />
                                    @endif

                                    @csrf

                                    <div>
                                        <x-primary-button class="btn btn-success">
                                            {{ __('Revoyer le mail') }}
                                        </x-primary-button>
                                    </div>
                                </form>

                                <form method="POST" action="{{ route('logout') }}" class="text-center">
                                    @csrf

                                    <button type="submit" class="btn btn-link">
                                        {{ __('Déconnexion') }}
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-guest-layout>
