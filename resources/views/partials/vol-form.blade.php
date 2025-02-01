<form x-show="activeTab === 'vols'" x-data="{ typeVol: '{{ old('type', 'one-way') }}' }" method="POST" action="{{ route('reservations.store.vol') }}">
    @csrf

    <h2>Réservez votre vol</h2>

    <input type="hidden" name="form_name" value="vol" required />
    <div x-data="{ activeStep: 'one' }">
        <div x-show="activeStep === 'one'">
            <div class="form-group">
                <label for="flight_type">Type</label>
                <select id="flight_type" name="type" x-model="typeVol">
                    <option value="one-way" {{ old('type') == 'one-way' ? 'selected' : '' }}>Aller simple</option>
                    <option value="round-trip" {{ old('type') == 'round-trip' ? 'selected' : '' }}>Aller-retour</option>
                    <option value="multi-destination" {{ old('type') == 'multi-destination' ? 'selected' : '' }}>Multi-destinations</option>
                </select>
                @error('type') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="passengers">Nombre de passagers</label>
                <select id="passengers" name="passengers">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('passengers') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('passengers') <span class="error">{{ $message }}</span> @enderror

                <label for="flight_class">Classe</label>
                <select id="flight_class" name="flight_class">
                    <option value="economy" {{ old('flight_class') == 'economy' ? 'selected' : '' }}>Économique</option>
                    <option value="premium" {{ old('flight_class') == 'premium' ? 'selected' : '' }}>Première</option>
                    <option value="business" {{ old('flight_class') == 'business' ? 'selected' : '' }}>Business</option>
                </select>
                @error('flight_class') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="origin">Origine</label>
                <select id="origin" name="origin">
                    <option value="N'Djamena" {{ old('origin') == "N'Djamena" ? 'selected' : '' }}>N'Djamena</option>
                    <option value="Moundou" {{ old('origin') == 'Moundou' ? 'selected' : '' }}>Moundou</option>
                </select>
                @error('origin') <span class="error">{{ $message }}</span> @enderror

                <label for="destination">Destination</label>
                <select id="destination" name="destination">
                    <option value="Paris" {{ old('destination') == 'Paris' ? 'selected' : '' }}>Paris</option>
                    <option value="Casablanca" {{ old('destination') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                </select>
                @error('destination') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="departure">Départ</label>
                <input type="date" id="departure" name="departure" value="{{ old('departure') }}" required>
                @error('departure') <span class="error">{{ $message }}</span> @enderror

                <label for="return">Retour</label>
                <input type="date" id="return" name="return" value="{{ old('return') }}" :disabled="typeVol === 'one-way'">
                @error('return') <span class="error">{{ $message }}</span> @enderror
            </div>
            <button type="button" @click="activeStep = 'two'">Suivant</button>
        </div>

        <div x-show="activeStep === 'two'">
            <div class="form-group">
                <label for="lastname">Nom</label>
                <input type="text" name="lastname" id="lastname" placeholder="Votre Nom" required />
                @error('lastname') <span class="error">{{ $message }}</span> @enderror

                <label for="firstname">Prénom(s)</label>
                <input type="text" id="firstname" name="firstname" placeholder="Vos prénoms">
                @error('firstname') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Votre Adresse mail">
                @error('email') <span class="error">{{ $message }}</span> @enderror

                <label for="phone">Téléphone</label>
                <input type="tel" id="phone" name="phone" placeholder="Votre numéro">
                @error('phone') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <button type="button" @click="activeStep = 'one'">Précédent</button>
                <button type="submit">Envoyer</button>
            </div>
        </div>
    </div>
</form>