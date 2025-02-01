<form x-show="activeTab === 'hotels'" method="POST" action="{{ route('reservations.store.hotel') }}" class="space-y-4">
    @csrf
    <h2 class="text-lg font-bold">Réservez votre hôtel</h2>
    
    <input type="hidden" name="form_name" value="hotel" required />
    <div x-data="{ activeStep: 'one' }">
        <div x-show="activeStep === 'one'">
            <div class="form-group">
                <label for="destinationHotel">Destination</label>
                <select id="destinationHotel" name="destination" class="border p-2 rounded w-full">
                    @foreach ($destinations as $destination)
                        <option value="{{ $destination }}">{{ $destination }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="checkin">Arrivée</label>
                <input type="date" id="checkin" name="checkin" class="border p-2 rounded w-full">

                <label for="checkout">Départ</label>
                <input type="date" id="checkout" name="checkout" class="border p-2 rounded w-full">
            </div>

            <div class="form-group">
                <label for="rooms">Nombre de chambre</label>
                <select name="rooms" id="rooms">
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
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