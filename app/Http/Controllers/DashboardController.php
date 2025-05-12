<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get events data
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('event_date', '>', now())->count();
        $pendingEvents = Event::where('status', 'pending')->count();
        $userEvents = Event::where('created_by', $user->id)->count();
        
        // Get recent events
        $events = Event::latest()->take(5)->get();
        
        // Get club memberships for students
        $clubMemberships = null;
        if ($user->user_type === 'student') {
            $clubMemberships = ClubMember::where('user_id', $user->id)
                ->with('club')
                ->latest()
                ->get();
        }
        
        return view('dashboard', compact(
            'totalEvents',
            'upcomingEvents',
            'pendingEvents',
            'userEvents',
            'events',
            'clubMemberships'
        ));
    }
} 