<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content'
    ];

    // Post → User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
