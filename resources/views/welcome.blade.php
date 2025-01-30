<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Voyage</title>
{{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
    @vite(['resources/js/app.js'])
</head>
<body>

    <header>Agence de voyage - Amazone Tchad</header>

    <div x-data="{ activeTab: 'vols' }" class="forms">
        <img src="{{ asset('assets/img/full.jpg') }}" alt="Amazone Tchad">

        <div class="content">
            <!-- Tabs -->
            <div class="tabs">
                <div class="tab" :class="{ 'active': activeTab === 'vols' }" @click="activeTab = 'vols'">Vols</div>
                <div class="tab" :class="{ 'active': activeTab === 'hotels' }" @click="activeTab = 'hotels'">Hôtels</div>
                <div class="tab" :class="{ 'active': activeTab === 'volhotel' }" @click="activeTab = 'volhotel'">Vol + Hôtel</div>
                <div class="tab" :class="{ 'active': activeTab === 'voiture' }" @click="activeTab = 'voiture'">Location de voiture</div>
            </div>
        
            <!-- Form Container -->
            <div class="form-container">
                @error('success')
                    <span>{{$success}}</span>
                @enderror
                <!-- Formulaire Vols -->
                @include('partials.vol-form')
                
                <!-- Formulaire Hôtels -->
                @include('partials.hotel-form')
            
                <!-- Formulaire Vol + Hôtel -->
                @include('partials.volhotel-form')
            
                <!-- Formulaire Location de Voiture -->
                @include('partials.carlocation-form')
                
            </div>
        </div>
        
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>
</html>
