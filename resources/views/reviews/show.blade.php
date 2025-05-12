@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Reviews for {{ $event->event_name }}</h3>
                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Back to All Reviews</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="event-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Club:</strong> {{ $event->club_name }}</p>
                                <p><strong>Date:</strong> {{ $event->event_date->format('M d, Y') }}</p>
                                <p><strong>Venue:</strong> {{ $event->venue }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h4>Average Rating</h4>
                                <div class="display-4 text-warning">
                                    {{ number_format($event->averageRating(), 1) }}/5
                                </div>
                                <p class="text-muted">Based on {{ $event->reviews->count() }} reviews</p>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->isStudent() && $event->participants()->where('user_id', auth()->id())->exists() && !$event->reviews()->where('user_id', auth()->id())->exists())
                        <div class="review-form mb-4">
                            <h4>Write a Review</h4>
                            <form action="{{ route('reviews.store', $event) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating (1-5)</label>
                                    <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                                </div>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                        </div>
                    @endif

                    <div class="reviews-list">
                        <h4>All Reviews</h4>
                        @if($event->reviews->isEmpty())
                            <div class="alert alert-info">
                                No reviews yet for this event.
                            </div>
                        @else
                            @foreach($event->reviews as $review)
                                <div class="review-item mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">{{ $review->user->name }}</h6>
                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                    </div>
                                    @if($review->rating)
                                        <div class="rating mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                    @endif
                                    @if($review->comment)
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    @endif
                                    @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 