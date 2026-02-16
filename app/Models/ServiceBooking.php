<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider_id',
        'service_id',
        'pet_id',
        'date',
        'date',
        'start_time',
        'end_time',
        'status',
        'phone',
        'address',
        'notes',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class , 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(PetService::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
