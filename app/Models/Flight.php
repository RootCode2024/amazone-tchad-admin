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

    public function country()
    {
        return $this->belongsTo(Airport::class, 'origin', 'id');
    }
    
    public function destination()
    {
        return $this->belongsTo(Airport::class, 'destination', 'id');
    }
    
    public function countries()
    {
        return $this->belongsTo(Airport::class, 'origin');
    }
    
    public function destinations()
    {
        return $this->belongsTo(Airport::class, 'destination');
    }
    
}
