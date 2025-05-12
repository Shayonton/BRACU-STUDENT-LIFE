<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            $events = Event::where('status', 'approved')
                ->where('event_date', '>=', now())
                ->orderBy('event_date')
                ->get();
        } elseif ($user->isClub()) {
            $events = Event::where('created_by', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $events = Event::orderBy('created_at', 'desc')->get();
        }

        return view('events.index', compact('events'));
    }

    public function upcoming()
    {
        $events = Event::where('status', 'approved')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->get();

        return view('events.upcoming', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Event creation request received', $request->all());
            
            $request->validate([
                'event_name' => ['required', 'string', 'max:255'],
                'club_name' => ['required', 'string', 'max:255'],
                'event_date' => ['required', 'date', 'after:today'],
                'venue' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:1000'],
                'needs_stalls' => ['nullable', 'boolean'],
                'number_of_stalls' => ['nullable', 'integer', 'min:1'],
                'registration_form_link' => ['required', 'url'],
                'event_link' => ['nullable', 'url'],
            ]);

            \Log::info('Validation passed');

            $eventData = [
                'event_name' => $request->event_name,
                'club_name' => $request->club_name,
                'event_date' => $request->event_date,
                'venue' => $request->venue,
                'description' => $request->description,
                'needs_stalls' => $request->boolean('needs_stalls'),
                'number_of_stalls' => $request->boolean('needs_stalls') ? $request->number_of_stalls : null,
                'registration_form_link' => $request->registration_form_link,
                'event_link' => $request->event_link,
                'status' => 'pending',
                'created_by' => Auth::id(),
            ];

            \Log::info('Event data prepared', $eventData);

            $event = Event::create($eventData);
            \Log::info('Event created successfully', ['event_id' => $event->id]);

            return redirect()->route('events.index')
                ->with('success', 'Event created successfully. Waiting for admin approval.');
        } catch (\Exception $e) {
            \Log::error('Error creating event: ' . $e->getMessage());
            \Log::error('Error stack trace: ' . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Failed to create event. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function approve(Event $event)
    {
        $event->update(['status' => 'approved']);
        return redirect()->route('events.index')
            ->with('success', 'Event approved successfully.');
    }

    public function reject(Event $event)
    {
        $event->update(['status' => 'rejected']);
        return redirect()->route('events.index')
            ->with('success', 'Event rejected successfully.');
    }

    public function destroy(Event $event)
    {
        try {
            $event->delete();
            return redirect()->route('events.index')
                ->with('success', 'Event deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting event: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete event. Please try again.');
        }
    }

    public function preRegister(Event $event)
    {
        try {
            $user = auth()->user();
            
            if ($user->registeredEvents()->where('event_id', $event->id)->exists()) {
                return back()->with('error', 'You have already pre-registered for this event.');
            }

            $user->registeredEvents()->attach($event->id, ['status' => 'pre_registered']);
            
            return back()->with('success', 'Successfully pre-registered for the event.');
        } catch (\Exception $e) {
            \Log::error('Error pre-registering for event: ' . $e->getMessage());
            return back()->with('error', 'Failed to pre-register for the event. Please try again.');
        }
    }

    public function showParticipants(Event $event)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isClub()) {
            abort(403);
        }

        $participants = $event->participants()->with('user')->get();
        return view('events.participants', compact('event', 'participants'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
} 