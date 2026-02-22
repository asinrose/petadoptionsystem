<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'breed',
        'age',
        'gender',
        'status',
        'description',
        'user_id',
        'image',
        'location',
        'type',
        'contact',
        'weight',
        'vaccination_status',
        'vaccination_date',
        'dewormed',
        'medical_conditions',
        'special_care_requirements',
        'adoption_type',
        'adoption_fee',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class , 'favorites')->withTimestamps();
    }
}
