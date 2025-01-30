<form x-show="activeTab === 'voiture'" action="" method="POST" class="space-y-4">
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
                <label for="conductor">Age du conducteur</label>
                <input type="number" required />
            </div>
            <button type="button" @click="activeStep = 'two'">Suivant</button>
        </div>

        <div x-show="activeStep === 'two'">
            <div class="form-group">
                <label for="lastname">Nom</label>
                <input type="text" name="lastname" id="lastname" placeholder="Votre Nom" required />
                @error('lastname') <span class="error">{{ $message }}</span> @enderror

                <label for="firstname">Prénom (s)</label>
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
                <button type="button" @click="activeStep = 'one'">Precedent</button>
                <button type="submit">Envoyer</button>
            </div>
        </div>
    </div>
</form>