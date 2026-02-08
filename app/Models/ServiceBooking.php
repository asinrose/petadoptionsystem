<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pet_id',
        'provider_id',
        'date',
        'time',
        'status'
    ];

    // Booking → User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Booking → Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    // Booking → Service Provider
    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class, 'provider_id');
    }
}
