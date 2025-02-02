<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['firstname', 'lastname', 'email', 'phone', 'type_of_reservation'];

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function carLocations()
    {
        return $this->hasMany(CarLocation::class);
    }

    
}
