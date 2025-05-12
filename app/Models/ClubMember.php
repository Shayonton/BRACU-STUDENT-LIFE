<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubMember extends Model
{
    protected $fillable = [
        'user_id',
        'club_id',
        'status',
        'application_note',
        'joined_at',
        'position',
    ];

    protected $casts = [
        'joined_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
} 