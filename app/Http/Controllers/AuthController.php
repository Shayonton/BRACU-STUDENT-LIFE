<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Event;
use App\Models\Room;
use App\Models\Club;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showStudentRegistrationForm()
    {
        return view('auth.register-student');
    }

    public function showClubRegistrationForm()
    {
        return view('auth.register-club');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function registerStudent(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'ends_with:@g.bracu.ac.bd'],
            'student_id' => ['required', 'string', 'max:255', 'unique:users,student_id,NULL,id,user_type,student', 'regex:/^[0-9]{8}$/'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'password' => Hash::make($request->password),
            'user_type' => 'student',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function registerClub(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'ends_with:@bracu.ac.bd'],
            'student_id' => ['required', 'string', 'max:255', 'regex:/^[0-9]{8}$/'],
            'club_representative_id' => ['required', 'string', 'max:255', 'regex:/^[0-9]{8}$/'],
            'phone_number' => ['required', 'string', 'max:255', 'regex:/^\+8801[3-9]\d{8}$/'],
            'club_representative_phone' => ['required', 'string', 'max:255', 'regex:/^\+8801[3-9]\d{8}$/'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url'],
        ]);

        // Check if the student IDs are different
        if ($request->student_id === $request->club_representative_id) {
            return back()->withErrors([
                'club_representative_id' => 'Primary student ID and representative student ID must be different.',
            ])->withInput();
        }

        // Check if the phone numbers are different
        if ($request->phone_number === $request->club_representative_phone) {
            return back()->withErrors([
                'club_representative_phone' => 'Primary phone number and representative phone number must be different.',
            ])->withInput();
        }

        // Create user record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'club_representative_id' => $request->club_representative_id,
            'phone_number' => $request->phone_number,
            'club_representative_phone' => $request->club_representative_phone,
            'password' => Hash::make($request->password),
            'user_type' => 'club',
        ]);

        // Create club record
        Club::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'description' => $request->description,
            'website' => $request->website,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function create()
    {
        $events = Event::where('created_by', Auth::id())
            ->where('status', 'approved')
            ->get();
        $rooms = Room::where('status', 'available')->get();
        return view('rooms.create', compact('events', 'rooms'));
    }
} 