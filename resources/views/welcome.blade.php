<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
	<title>Réservation - {{ config('app.name', 'Laravel') }}</title>
    
	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    
	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}" />
    
	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" />
    @vite(['resources/js/app.js'])
</head>

<body>
	<div id="booking" class="section" x-data="{ activeTab: 'vols' }">
        <img src="{{ asset('assets/img/logo.png') }}" alt="logo" style="width: auto; height: 100px;">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<div class="booking-cta">
							<h1>Réservez dès maintenant</h1>
							<p style="font-size: 17px">
                                <em>
                                    Amazone Tchad vous permet de réserver votre voyage en ligne simplement et rapidement. Nos équipes sont à votre disposition pour vous aider à trouver les meilleurs vols, les hôtels les plus confortables et les voitures les plus économiques.
                                </em>
                            </p>
						</div>
					</div>
					<div class="col-md-7 col-md-offset-1">
                        <!-- Tabs -->
                        <div class="col-12 d-flex justify-content-center tabs">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a style="cursor: pointer;" class="nav-link" :class="{ 'active': activeTab === 'vols' }" @click="activeTab = 'vols'">Vols</a>
                                </li>
                                <li class="nav-item">
                                    <a style="cursor: pointer;" class="nav-link" :class="{ 'active': activeTab === 'hotels' }" @click="activeTab = 'hotels'">Hôtels</a>
                                </li>
                                <li class="nav-item">
                                    <a style="cursor: pointer;" class="nav-link" :class="{ 'active': activeTab === 'volhotel' }" @click="activeTab = 'volhotel'">Vol + Hôtel</a>
                                </li>
                                <li class="nav-item">
                                    <a style="cursor: pointer;" class="nav-link" :class="{ 'active': activeTab === 'voiture' }" @click="activeTab = 'voiture'">Location de voiture</a>
                                </li>
                            </ul>
                        </div>
                        
						<div class="booking-form">
                            <div class="row mt-4">
                                <!-- Form Container -->
                            <div class="col-12 form-container">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                
                                <!-- Formulaire Vols -->
                                <div x-show="activeTab === 'vols'">
                                    @include('partials.vol-form')
                                </div>
                                  
                                <!-- Formulaire Hôtels -->
                                <div x-show="activeTab === 'hotels'">
                                    @include('partials.hotel-form')
                                </div>
                        
                                <!-- Formulaire Vol + Hôtel -->
                                <div x-show="activeTab === 'volhotel'">
                                    @include('partials.volhotel-form')
                                </div>
                        
                                <!-- Formulaire Location de Voiture -->
                                <div x-show="activeTab === 'voiture'">
                                    @include('partials.carlocation-form')
                                </div>
                            </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>