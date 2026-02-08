<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use HasFactory;

    // Pet → Adoption Requests
    public function adoptionRequests()
    {
        return $this->hasMany(AdoptionRequest::class);
    }

    // Pet → Service Bookings
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }
}
