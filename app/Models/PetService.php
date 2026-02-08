<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_provider_id',
        'name',
        'description',
        'price',
        'duration_minutes',
        'is_active',
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}
