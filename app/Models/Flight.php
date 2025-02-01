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
        return $this->belongsTo(Client::class);
    }
}
