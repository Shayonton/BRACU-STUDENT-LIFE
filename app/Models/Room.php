<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_code',
        'floor',
        'block',
        'room_number',
        'room_type',
        'capacity',
        'features',
        'status'
    ];

    protected $casts = [
        'features' => 'array'
    ];

    public function bookings()
    {
        return $this->hasMany(RoomBooking::class);
    }

    public function getRoomTypeNameAttribute()
    {
        return [
            'C' => 'Classroom',
            'L' => 'Computer Lab',
            'A' => 'Auditorium',
            'R' => 'Rehearsal Room',
            'CR' => 'Club Room'
        ][$this->room_type] ?? $this->room_type;
    }

    public function isAvailable($date, $startTime, $endTime)
    {
        return !$this->bookings()
            ->where('booking_date', $date)
            ->where('status', 'approved')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
                });
            })->exists();
    }
} 