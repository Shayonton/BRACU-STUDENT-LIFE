<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        $roomBookings = collect();
        if ($user->isClub()) {
            $roomBookings = RoomBooking::with(['room', 'event'])
                ->whereHas('event', function($query) use ($user) {
                    $query->where('created_by', $user->id);
                })
                ->orderBy('date', 'desc')
                ->orderBy('start_time', 'desc')
                ->get();
        }
        
        return view('profile.show', compact('user', 'profile', 'roomBookings'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'address' => ['nullable', 'string', 'max:255'],
            'current_semester' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $profileData = [
            'address' => $request->address,
            'current_semester' => $request->current_semester,
            'department' => $request->department,
            'bio' => $request->bio,
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $profileData['user_id'] = $user->id;
            UserProfile::create($profileData);
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }
} 