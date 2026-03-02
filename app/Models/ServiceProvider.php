<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_type',
        'verification_status'
    ];

    // Provider → User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(PetService::class);
    }

    // Provider → Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Provider → Bookings
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class , 'provider_id');
    }
}
