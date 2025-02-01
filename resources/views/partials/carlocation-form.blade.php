<form x-show="activeTab === 'voiture'" method="POST" action="{{ route('reservations.store.location') }}" class="space-y-4" x-data="{ activeStep: 'one', errors: {}}">
    @csrf
    
    <!-- Étape 1 : Informations sur la location -->
    <div x-show="activeStep === 'one'" x-ref="stepOneContainer">

        <!-- Lieu de prise en charge -->
        <div class="form-group">
            <span class="form-label">Lieu de prise en charge</span>
            <select id="place_of_location" name="place_of_location" class="form-control" required>
                @foreach ($airports as $airport)
                    <option value="{{ $airport->id }}" {{ old('place_oflocation') == $airport->id ? 'selected' : '' }}>
                        {{ $airport->country . ' ( ' . Str::lower($airport->airport_name) . ' )' }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Dates -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Debut</span>
                    <input class="form-control" type="date" name="started_date" id="started_date" required>
                    <span class="error text-danger" x-text="errors['started_date']"></span>
                    @error('started_date')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Fin</span>
                    <input class="form-control" type="date" name="ended_date" id="ended_date" required>
                    <span class="error text-danger" x-text="errors['ended_date']"></span>
                    @error('ended_date')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
        </div>

        <!-- Age -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Age du conducteur</span>
                    <input type="text" name="age" id="age" class="form-control" placeholder="Votre Age"
                    required minlength="2">
                    @error('age')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
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
