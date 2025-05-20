<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Club;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $clubs = Club::latest()->take(6)->get();
        $upcomingEvents = Event::where('status', 'approved')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(3)
            ->get();
        return view('welcome', compact('clubs', 'upcomingEvents'));
    }
} 