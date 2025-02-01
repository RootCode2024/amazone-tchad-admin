<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'country_id',
        'arrival_date',
        'return_date',
        'number_of_room',
        'type',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
