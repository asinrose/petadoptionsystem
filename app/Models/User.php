<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\AdoptionRequest;
use App\Models\CommunityPost;
use App\Models\ServiceBooking;
use App\Models\ServiceProvider;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function adoptionRequests()
    {
        return $this->hasMany(AdoptionRequest::class);
    }

    // User → Community Posts
    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    // User → Service Bookings
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    // User → Service Provider Profile
    public function serviceProvider()
    {
        return $this->hasOne(ServiceProvider::class);
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
