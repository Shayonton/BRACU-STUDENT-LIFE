<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'student_id',
        'phone_number',
        'club_representative_id',
        'club_representative_phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'participants', 'user_id', 'event_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isStudent()
    {
        return $this->user_type === 'student';
    }

    public function isClub()
    {
        return $this->user_type === 'club';
    }
}
