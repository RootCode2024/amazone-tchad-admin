<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Voyage</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <style>²
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        header {
            background: #0056b3;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .tabs {
            display: flex;
            justify-content: center;
            background: #e6e9ee;
            padding: 10px;
        }

        .tab {
            padding: 10px 20px;
            margin: 0 10px;
            background: #ffffff;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s;
        }

        .tab.active {
            background: #0056b3;
            color: white;
        }

        .tab:hover {
            background: #dce3ea;
        }

        .form-container {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 20px auto;
        }

        .form-group {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-group label {
            flex: 0 0 100px; /* Largeur fixe pour aligner les labels */
            font-weight: 500;
            color: #555;
        }

        .form-group select {
            flex: 1; /* Prend l'espace disponible */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }


        .form-group input {
            flex: 1 1 calc(50% - 15px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 15px;
            background: #0056b3;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background: #003d7a;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

    </style>
</head>
<body>

    <header>Agence de voyage Amazone Tchad</header>

    <div x-data="{ activeTab: 'vols' }">
        <!-- Tabs -->
        <div class="tabs">
            <div class="tab" :class="{ 'active': activeTab === 'vols' }" @click="activeTab = 'vols'">Vols</div>
            <div class="tab" :class="{ 'active': activeTab === 'hotels' }" @click="activeTab = 'hotels'">Hôtels</div>
            <div class="tab" :class="{ 'active': activeTab === 'volhotel' }" @click="activeTab = 'volhotel'">Vol + Hôtel</div>
            <div class="tab" :class="{ 'active': activeTab === 'voiture' }" @click="activeTab = 'voiture'">Location de voiture</div>
        </div>
    
        <!-- Form Container -->
        <div class="form-container">
            <!-- Formulaire Vols -->
            <form x-show="activeTab === 'vols'" x-data="{ typeVol: '{{ old('type', 'one-way') }}' }" method="POST" action="{{ route('reservations.store') }}">
                @csrf
                <h2>Réservez votre vol</h2>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" x-model="typeVol">
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
                    <input type="date" id="return" name="return" value="{{ old('return') }}" :disabled="typeVol === 'Aller simple'">
                    @error('return') <span class="error">{{ $message }}</span> @enderror
                </div>

                <hr>
                <em>Informations du passager principal</em>

                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" placeholder="Nom" required>
                    @error('lastname') <span class="error">{{ $message }}</span> @enderror

                    <label for="firstname">Prénom (s)</label>
                    <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Prénom" required>
                    @error('firstname') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    @error('email') <span class="error">{{ $message }}</span> @enderror

                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Téléphone" required>
                    @error('phone') <span class="error">{{ $message }}</span> @enderror
                </div>

                <button type="submit">Envoyer</button>
            </form>
             
            <!-- Formulaire Hôtels -->
            <form x-show="activeTab === 'hotels'" @submit.prevent="alert('Réservation d\'hôtel en cours...')">
                <h2>Réservez votre hôtel</h2>
                <div class="form-group">
                    <label for="destinationHotel">Destination</label>
                    <select id="destinationHotel">
                        <option>Paris</option>
                        <option>Casablanca</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="checkin">Arrivée</label>
                    <input type="text" id="checkin" placeholder="Choisissez une date">
                    <label for="checkout">Départ</label>
                    <input type="text" id="checkout" placeholder="Choisissez une date">
                </div>
                <button type="submit">Rechercher</button>
            </form>
    
            <!-- Formulaire Vol + Hôtel -->
            <form x-show="activeTab === 'volhotel'" @submit.prevent="alert('Réservation Vol + Hôtel en cours...')">
                <h2>Réservez Vol + Hôtel</h2>
                <div class="form-group">
                    <label for="originVH">Origine</label>
                    <select id="originVH">
                        <option>N'Djamena</option>
                    </select>
                    <label for="destinationVH">Destination</label>
                    <select id="destinationVH">
                        <option>Paris</option>
                    </select>
                </div>
                <button type="submit">Rechercher</button>
            </form>
    
            <!-- Formulaire Location de Voiture -->
            <form x-show="activeTab === 'voiture'" @submit.prevent="alert('Réservation de voiture en cours...')">
                <h2>Réservez une voiture</h2>
                <div class="form-group">
                    <label for="pickup">Lieu de prise en charge</label>
                    <select id="pickup">
                        <option>N'Djamena</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="startDate">Début</label>
                    <input type="text" id="startDate" placeholder="Choisissez une date">
                    <label for="endDate">Fin</label>
                    <input type="text" id="endDate" placeholder="Choisissez une date">
                </div>
                <button type="submit">Rechercher</button>
            </form>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#departure, #return, #checkin, #checkout, #startDate, #endDate", {
            dateFormat: "d/m/Y",
        });
    </script>

</body>
</html>
