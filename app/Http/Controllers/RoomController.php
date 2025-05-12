<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rooms = Room::where('status', 'available')->get();
        if ($user->isAdmin()) {
            $bookings = RoomBooking::with(['room', 'event'])
                ->orderBy('booking_date', 'desc')
                ->get();
        } else {
            $bookings = RoomBooking::with(['room', 'event'])
                ->where('created_by', $user->id)
                ->orderBy('booking_date', 'desc')
                ->get();
        }
        return view('rooms.index', compact('rooms', 'bookings'));
    }

    public function create()
    {
        if (!auth()->user()->isClub()) {
            return redirect()->route('rooms.index')->with('error', 'Only clubs can book rooms.');
        }
        $events = \App\Models\Event::where('created_by', \Auth::id())
            ->where('status', 'approved')
            ->get();
        $rooms = \App\Models\Room::where('status', 'available')->get();
        return view('rooms.create', compact('events', 'rooms'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isClub()) {
            return redirect()->route('rooms.index')->with('error', 'Only clubs can book rooms.');
        }
        try {
            $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'event_id' => 'required|exists:events,id',
                'booking_date' => 'required|date|after:today',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
            ]);

            // Check for overlapping bookings
            $overlapping = RoomBooking::where('room_id', $request->room_id)
                ->where('booking_date', $request->booking_date)
                ->where(function($query) use ($request) {
                    $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                        ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
                })
                ->exists();

            if ($overlapping) {
                return back()->with('error', 'This room is already booked for the selected time slot.');
            }

            RoomBooking::create([
                'room_id' => $request->room_id,
                'event_id' => $request->event_id,
                'booking_date' => $request->booking_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => 'pending',
                'created_by' => Auth::id()
            ]);

            return redirect()->route('rooms.index')
                ->with('success', 'Room booking request submitted successfully. Waiting for admin approval.');
        } catch (\Exception $e) {
            \Log::error('Error creating room booking: ' . $e->getMessage());
            return back()->with('error', 'Failed to create room booking. Please try again.');
        }
    }

    public function approve(RoomBooking $booking)
    {
        try {
            $booking->update(['status' => 'approved']);
            return redirect()->route('rooms.index')
                ->with('success', 'Room booking approved successfully.');
        } catch (\Exception $e) {
            \Log::error('Error approving room booking: ' . $e->getMessage());
            return back()->with('error', 'Failed to approve room booking. Please try again.');
        }
    }

    public function reject(RoomBooking $booking)
    {
        try {
            $booking->update(['status' => 'rejected']);
            return redirect()->route('rooms.index')
                ->with('success', 'Room booking rejected successfully.');
        } catch (\Exception $e) {
            \Log::error('Error rejecting room booking: ' . $e->getMessage());
            return back()->with('error', 'Failed to reject room booking. Please try again.');
        }
    }

    public function destroy(RoomBooking $booking)
    {
        try {
            $booking->delete();
            return redirect()->route('rooms.index')
                ->with('success', 'Room booking deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting room booking: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete room booking. Please try again.');
        }
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'floor' => 'nullable|integer|min:2|max:12',
            'room_type' => 'nullable|in:C,L,A,R,CR'
        ]);

        $query = Room::where('status', 'available');

        if ($request->floor) {
            $query->where('floor', $request->floor);
        }

        if ($request->room_type) {
            $query->where('room_type', $request->room_type);
        }

        $availableRooms = $query->get()->filter(function($room) use ($request) {
            return $room->isAvailable(
                $request->date,
                $request->start_time,
                $request->end_time
            );
        });

        return response()->json([
            'rooms' => $availableRooms
        ]);
    }

    public function book(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time'
        ]);

        $user = Auth::user();
        
        // Get the latest/current event for the club
        $event = Event::where('created_by', $user->id)
                      ->where('status', 'approved')
                      ->orderBy('created_at', 'desc')
                      ->first();
        
        if (!$event) {
            return back()->with('error', 'Please create and get approval for an event before booking a room.');
        }

        $room = Room::findOrFail($request->room_id);
        
        if (!$room->isAvailable($request->date, $request->start_time, $request->end_time)) {
            return back()->with('error', 'Room is not available for the selected time slot.');
        }

        RoomBooking::create([
            'room_id' => $request->room_id,
            'event_id' => $event->id,
            'booking_date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => Auth::user()->isAdmin() ? 'approved' : 'pending',
            'created_by' => Auth::id()
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Room booking request submitted successfully.');
    }

    public function approveBooking(RoomBooking $booking)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Only administrators can approve bookings.');
        }

        $booking->update(['status' => 'approved']);
        return back()->with('success', 'Room booking approved successfully.');
    }

    public function rejectBooking(RoomBooking $booking)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Only administrators can reject bookings.');
        }

        $booking->update(['status' => 'rejected']);
        return back()->with('success', 'Room booking rejected successfully.');
    }
} 