<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarLocation extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'place_of_location', 'started_date', 'ended_date', 'age', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
