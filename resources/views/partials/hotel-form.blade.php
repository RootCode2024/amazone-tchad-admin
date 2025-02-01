<form x-show="activeTab === 'hotels'" method="POST" action="{{ route('reservations.store.hotel') }}" class="space-y-4" x-data="{ activeStep: 'one', errors: {}}">
    @csrf
    
    <!-- Étape 1 : Informations sur la reservation -->
    <div x-show="activeStep === 'one'" x-ref="stepOneContainer">

        <!-- Destination -->
        <div class="form-group">
            <span class="form-label">Destination</span>
            <select id="destination" name="destination" class="form-control" required>
                @foreach ($airports as $airport)
                    <option value="{{ $airport->id }}" {{ old('destination') == $airport->id ? 'selected' : '' }}>
                        {{ $airport->country . ' ( ' . Str::lower($airport->airport_name) . ' )' }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Date d'arrivée</span>
                    <input class="form-control" type="date" name="arrival_date" id="arrival_date" required>
                    <span class="error text-danger" x-text="errors['arrival_date']"></span>
                    @error('arrival_date')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Date de départ</span>
                    <input class="form-control" type="date" name="return_date" id="return_date" required>
                    <span class="error text-danger" x-text="errors['return_date']"></span>
                    @error('return_date')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
        </div>

        <!-- Nombre de chambre -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Nombre de Chambre</span>
                    <select id="number_of_room" name="number_of_room" class="form-control" required>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ old('number_of_room') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <span class="select-arrow"></span>
                </div>
            </div>
        </div>

        <button type="button" @click="activeStep = 'two'">Suivant</button>
    </div>
    
    <!-- Étape 2 : Informations personnelles -->
    <div x-show="activeStep === 'two'">
        <!-- Informations personnelles -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Nom</span>
                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Votre Nom"
                    required minlength="2">
                    @error('lastname')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Prénom (s)</span>
                    <input type="text" id="firstname" name="firstname" class="form-control"
                    placeholder="Vos prénoms" required minlength="2">
                    @error('firstname')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Email</span>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Votre Adresse mail"
                    required minlength="2">
                    @error('email')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Téléphone</span>
                    <input type="text" id="phone" name="phone" class="form-control"
                    placeholder="Votre numéro" required minlength="2">
                    @error('phone')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12 col-md-6">
                <button type="button" class="btn btn-secondary" @click="activeStep = 'one'">Précédent</button>
            </div>
            <div class="col-12 col-md-6 text-right">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </div>
    </div>
</form>
