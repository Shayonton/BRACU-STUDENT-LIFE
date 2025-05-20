<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'email',
        'phone',
        'website',
        'location',
    ];

    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }
}
