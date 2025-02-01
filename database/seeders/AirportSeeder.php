<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    public function run()
    {
        $airports = [
            ['country' => 'Afghanistan', 'airport_name' => 'Aéroport international Hamid Karzai', 'iata' => 'KBL'],
            ['country' => 'Afrique du Sud', 'airport_name' => 'Aéroport international OR Tambo', 'iata' => 'JNB'],
            ['country' => 'Albanie', 'airport_name' => 'Aéroport international de Tirana', 'iata' => 'TIA'],
            ['country' => 'Algérie', 'airport_name' => 'Aéroport international d\'Alger Houari Boumédiène', 'iata' => 'ALG'],
            ['country' => 'Allemagne', 'airport_name' => 'Aéroport de Francfort', 'iata' => 'FRA'],
            ['country' => 'Arabie Saoudite', 'airport_name' => 'Aéroport international du Roi-Abdelaziz', 'iata' => 'JED'],
            ['country' => 'Argentine', 'airport_name' => 'Aéroport international Ministro-Pistarini', 'iata' => 'EZE'],
            ['country' => 'Australie', 'airport_name' => 'Aéroport Kingsford Smith de Sydney', 'iata' => 'SYD'],
            ['country' => 'Belgique', 'airport_name' => 'Aéroport de Bruxelles', 'iata' => 'BRU'],
            ['country' => 'Brésil', 'airport_name' => 'Aéroport international de São Paulo-Guarulhos', 'iata' => 'GRU'],
            ['country' => 'Canada', 'airport_name' => 'Aéroport international Pearson de Toronto', 'iata' => 'YYZ'],
            ['country' => 'Chine', 'airport_name' => 'Aéroport international de Pékin-Capitale', 'iata' => 'PEK'],
            ['country' => 'Égypte', 'airport_name' => 'Aéroport international du Caire', 'iata' => 'CAI'],
            ['country' => 'Espagne', 'airport_name' => 'Aéroport Adolfo Suárez Madrid-Barajas', 'iata' => 'MAD'],
            ['country' => 'États-Unis', 'airport_name' => 'Aéroport international Hartsfield-Jackson d\'Atlanta', 'iata' => 'ATL'],
            ['country' => 'France', 'airport_name' => 'Aéroport Charles de Gaulle', 'iata' => 'CDG'],
            ['country' => 'Inde', 'airport_name' => 'Aéroport international Indira-Gandhi de Delhi', 'iata' => 'DEL'],
            ['country' => 'Italie', 'airport_name' => 'Aéroport Léonard-de-Vinci de Rome Fiumicino', 'iata' => 'FCO'],
            ['country' => 'Japon', 'airport_name' => 'Aéroport international de Tokyo-Haneda', 'iata' => 'HND'],
            ['country' => 'Maroc', 'airport_name' => 'Aéroport Mohammed-V de Casablanca', 'iata' => 'CMN'],
            ['country' => 'Mexique', 'airport_name' => 'Aéroport international de Mexico-Benito Juárez', 'iata' => 'MEX'],
            ['country' => 'Pays-Bas', 'airport_name' => 'Aéroport d\'Amsterdam-Schiphol', 'iata' => 'AMS'],
            ['country' => 'Portugal', 'airport_name' => 'Aéroport Humberto Delgado de Lisbonne', 'iata' => 'LIS'],
            ['country' => 'Royaume-Uni', 'airport_name' => 'Aéroport de Londres Heathrow', 'iata' => 'LHR'],
            ['country' => 'Russie', 'airport_name' => 'Aéroport international Cheremetievo', 'iata' => 'SVO'],
            ['country' => 'Singapour', 'airport_name' => 'Aéroport de Singapour-Changi', 'iata' => 'SIN'],
            ['country' => 'Suisse', 'airport_name' => 'Aéroport de Zurich', 'iata' => 'ZRH'],
            ['country' => 'Thaïlande', 'airport_name' => 'Aéroport Suvarnabhumi de Bangkok', 'iata' => 'BKK'],
            ['country' => 'Turquie', 'airport_name' => 'Aéroport d\'Istanbul', 'iata' => 'IST']
        ];

        DB::table('airports')->insert($airports);
    }
}
