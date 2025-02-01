<form x-show="activeTab === 'volhotel'" x-data="{ typeVolHotel: '{{ old('typeVol', 'one-way') }}' }" method="POST" action="{{ route('reservations.store.volhotel') }}">
    @csrf

    <h2 class="text-lg font-bold">Réservez Vol + Hôtel</h2>

    <div x-data="{ activeStepVH: 'one' }">
        <div x-show="activeStepVH === 'one'">
            <div class="form-group">
                <label for="typeVH">Type</label>
                <!-- Utilisation cohérente de typeVolHotel -->
                <select id="typeVH" name="type" x-model="typeVolHotel">
                    <option value="one-way" {{ old('type') == 'one-way' ? 'selected' : '' }}>Aller simple</option>
                    <option value="round-trip" {{ old('type') == 'round-trip' ? 'selected' : '' }}>Aller-retour</option>
                    <option value="multi-destination" {{ old('type') == 'multi-destination' ? 'selected' : '' }}>Multi-destinations</option>
                </select>
                @error('type') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="passengersVH">Nombre de passagers</label>
                <select id="passengersVH" name="passengers">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('passengers') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('passengers') <span class="error">{{ $message }}</span> @enderror

                <label for="flight_classVH">Classe</label>
                <select id="flight_classVH" name="flight_class">
                    <option value="economy" {{ old('flight_class') == 'economy' ? 'selected' : '' }}>Économique</option>
                    <option value="premium" {{ old('flight_class') == 'premium' ? 'selected' : '' }}>Première</option>
                    <option value="business" {{ old('flight_class') == 'business' ? 'selected' : '' }}>Business</option>
                </select>
                @error('flight_class') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="originVH">Origine</label>
                <select id="originVH" name="origin">
                    <option value="N'Djamena" {{ old('origin') == "N'Djamena" ? 'selected' : '' }}>N'Djamena</option>
                    <option value="Moundou" {{ old('origin') == 'Moundou' ? 'selected' : '' }}>Moundou</option>
                </select>
                @error('origin') <span class="error">{{ $message }}</span> @enderror

                <label for="destinationVH">Destination</label>
                <select id="destinationVH" name="destination">
                    <option value="Paris" {{ old('destination') == 'Paris' ? 'selected' : '' }}>Paris</option>
                    <option value="Casablanca" {{ old('destination') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                </select>
                @error('destination') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="departureVH">Départ</label>
                <input type="date" id="departureVH" name="departure" value="{{ old('departure') }}" required>
                @error('departure') <span class="error">{{ $message }}</span> @enderror

                <label for="returnVH">Retour</label>
                <input type="date" id="returnVH" name="return" value="{{ old('return') }}" :disabled="typeVolHotel === 'one-way'">
                @error('return') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="room_count">Nombre de chambre</label>
                <select id="room_count" name="room_count">
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <button type="button" @click="activeStepVH = 'two'">Suivant</button>
        </div>

        <div x-show="activeStepVH === 'two'">
            <div class="form-group">
                <label for="lastnameVH">Nom</label>
                <input type="text" name="lastname" id="lastnameVH" placeholder="Votre Nom" required />
                @error('lastname') <span class="error">{{ $message }}</span> @enderror

                <label for="firstnameVH">Prénom(s)</label>
                <input type="text" id="firstnameVH" name="firstname" placeholder="Vos prénoms">
                @error('firstname') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="emailVH">Email</label>
                <input type="email" id="emailVH" name="email" placeholder="Votre Adresse mail">
                @error('email') <span class="error">{{ $message }}</span> @enderror

                <label for="phoneVH">Téléphone</label>
                <input type="tel" id="phoneVH" name="phone" placeholder="Votre numéro">
                @error('phone') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <button type="button" @click="activeStepVH = 'one'">Précédent</button>
                <button type="submit">Envoyer</button>
            </div>
        </div>
    </div>
</form>