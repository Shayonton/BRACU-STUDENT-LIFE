<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'current_semester',
        'department',
        'bio',
        'club_name',
        'club_description',
        'club_website',
        'club_facebook',
        'club_instagram',
        'club_logo',
        'club_members'
    ];

    protected $casts = [
        'club_members' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 