<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('event_name', 'like', "%{$search}%");
        }

        $events = $query->whereHas('reviews')
            ->with(['reviews.user'])
            ->orderBy('event_date', 'desc')
            ->paginate(10);

        return view('reviews.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['reviews.user']);
        return view('reviews.show', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        if (!auth()->user()->isStudent()) {
            return back()->with('error', 'Only students can review events.');
        }

        $request->validate([
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        // Check if user has already reviewed this event
        if ($event->reviews()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already reviewed this event.');
        }

        Review::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    public function destroy(Review $review)
    {
        if (auth()->id() !== $review->user_id && !auth()->user()->isAdmin()) {
            return back()->with('error', 'You are not authorized to delete this review.');
        }

        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
} 