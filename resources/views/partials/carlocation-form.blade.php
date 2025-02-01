<form x-show="activeTab === 'voiture'" method="POST" action="{{ route('reservations.store.location') }}" class="space-y-4">
    @csrf
    <h2 class="text-lg font-bold">Réservez une voiture</h2>
    <div x-data="{ activeStep: 'one' }">
        <div x-show="activeStep === 'one'">
            <div class="form-group">
                <label for="pickup">Lieu de prise en charge</label>
                <select id="pickup" name="pickup" class="border p-2 rounded w-full">
                    @foreach ($pickupLocations as $pickup)
                        <option value="{{ $pickup }}">{{ $pickup }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="startDate">Début</label>
                <input type="date" id="startDate" name="startDate" class="border p-2 rounded w-full">

                <label for="endDate">Fin</label>
                <input type="date" id="endDate" name="endDate" class="border p-2 rounded w-full">
            </div>

            <div class="form-group">
                <label for="conductor">Âge du conducteur</label>
                <input type="number" id="conductor" name="conductor" required>
            </div>
            <button type="button" @click="activeStep = 'two'">Suivant</button>
        </div>

        <div x-show="activeStep === 'two'">
            <div class="form-group">
                <label for="lastnameCar">Nom</label>
                <input type="text" name="lastname" id="lastnameCar" placeholder="Votre Nom" required />
                @error('lastname') <span class="error">{{ $message }}</span> @enderror

                <label for="firstnameCar">Prénom(s)</label>
                <input type="text" id="firstnameCar" name="firstname" placeholder="Vos prénoms">
                @error('firstname') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="emailCar">Email</label>
                <input type="email" id="emailCar" name="email" placeholder="Votre Adresse mail">
                @error('email') <span class="error">{{ $message }}</span> @enderror

                <label for="phoneCar">Téléphone</label>
                <input type="tel" id="phoneCar" name="phone" placeholder="Votre numéro">
                @error('phone') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <button type="button" @click="activeStep = 'one'">Précédent</button>
                <button type="submit">Envoyer</button>
            </div>
        </div>
    </div>
</form>