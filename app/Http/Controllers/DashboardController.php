<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ClubMember;
use App\Models\Club;
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
        if ($user->isStudent()) {
            $events = Event::where('status', 'approved')
                ->where('event_date', '>=', now())
                ->orderBy('event_date')
                ->take(5)
                ->get();
        } else {
            $events = Event::latest()->take(5)->get();
        }
        
        $data = [
            'totalEvents' => $totalEvents,
            'upcomingEvents' => $upcomingEvents,
            'pendingEvents' => $pendingEvents,
            'userEvents' => $userEvents,
            'events' => $events,
        ];

        // Get club memberships for students
        if ($user->user_type === 'student') {
            $data['clubMemberships'] = ClubMember::where('user_id', $user->id)
                ->with('club')
                ->latest()
                ->get();
        }

        // Add club members data for admin users
        if ($user->isAdmin()) {
            $data['allClubMembers'] = ClubMember::with(['user', 'club'])
                ->where('status', 'approved')
                ->latest()
                ->get();
        }

        return view('dashboard', $data);
    }
} 