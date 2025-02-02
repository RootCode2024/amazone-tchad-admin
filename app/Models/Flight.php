<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'origin',
        'destination',
        'departure_date',
        'return_date',
        'passengers',
        'flight_class',
        'flight_type',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Relation pour l'aéroport d'origine (départ)
    public function country()
    {
        return $this->belongsTo(Airport::class, 'origin');
    }

    /**
     * Relation vers l'aéroport d'arrivée.
     * On suppose que la colonne "destination" dans la table flights stocke l'id de l'aéroport d'arrivée.
     */
    public function destination()
    {
        return $this->belongsTo(Airport::class, 'destination');
    }
}
