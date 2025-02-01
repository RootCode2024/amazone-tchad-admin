<form x-show="activeTab === 'volhotel'"
      x-data="{ typeVolVH: 'one-way', activeStep: 'one', errors: {} }"
      x-init="typeVolVH = '{{ old('flight_typeVH', 'one-way') }}'"
      method="POST"
      action="{{ route('reservations.store.volhotel') }}">

    @csrf

    <!-- Étape 1 : Informations sur le vol -->
    <div x-show="activeStep === 'one'" x-ref="stepOneContainer">
        
        <!-- Type de vol -->
        <div class="form-group">
            <div class="form-checkbox">
                <label>
                    <input type="radio" name="flight_typeVH" value="round-trip" x-model="typeVolVH" required>
                    <span></span> Aller-Retour
                </label>
                <label>
                    <input type="radio" name="flight_typeVH" value="one-way" x-model="typeVolVH" required>
                    <span></span> Aller Simple
                </label>
                <label>
                    <input type="radio" name="flight_typeVH" value="multi-destination" x-model="typeVolVH" required>
                    <span></span> Multi-destination
                </label>
            </div>
            <p x-text="'Type de vol sélectionné : ' + typeVolVH"></p>
            <span class="error text-danger" x-text="errors['flight_typeVH']"></span>
            @error('flight_typeVH')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
        
         <!-- Origine et destination -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Lieu de départ</span>
                    <select id="origin" name="origin" class="form-control" required>
                        @foreach ($airports as $airport)
                            <option value="{{ $airport->id }}" {{ old('origin') == $airport->id ? 'selected' : '' }}>
                                {{ $airport->country . ' ( ' . Str::lower($airport->airport_name) . ' )' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
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
            </div>
        </div>

        <!-- Dates -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Date départ</span>
                    <input class="form-control" type="date" name="departure" id="departure" required>
                    <span class="error text-danger" x-text="errors['departure']"></span>
                    @error('departure')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <span class="form-label">Date Retour</span>
                    <input class="form-control" type="date" name="return" id="return" :disabled="typeVolVH === 'one-way'" x-bind:required="typeVolVH !== 'one-way'" required>
                    <span class="error text-danger" x-text="errors['return']"></span>
                    @error('return')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Nombre de passager, Classe, Nombre de chambre -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <span class="form-label">Nombre de Passagers</span>
                    <select id="passengers" name="passengers" class="form-control" required>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ old('passengers') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                    <span class="select-arrow"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <span class="form-label">Classe</span>
                    <select class="form-control" id="flight_class" name="flight_class" required>
                        <option value="economy" {{ old('flight_class') == 'economy' ? 'selected' : '' }}>Économique
                        </option>
                        <option value="premium" {{ old('flight_class') == 'premium' ? 'selected' : '' }}>Première</option>
                        <option value="business" {{ old('flight_class') == 'business' ? 'selected' : '' }}>Business
                        </option>
                    </select>
                    <span class="select-arrow"></span>
                </div>
            </div>
            <div class="col-md-4">
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

        <button type="button" class="btn btn-primary mt-3"
            @click="errors = {}; const inputs = $refs.stepOneContainer.querySelectorAll('input[required], select[required]'); let valid = true; inputs.forEach(input => { if (!input.checkValidity()) { valid = false; errors[input.name] = input.validationMessage; } else { errors[input.name] = ''; } }); if (valid) { activeStep = 'two'; }">
            Suivant
        </button>
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