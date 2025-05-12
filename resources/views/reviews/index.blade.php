@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Event Reviews</h3>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <form action="{{ route('reviews.index') }}" method="GET" class="row g-3">
                            <div class="col-md-8">
                                <input type="text" name="search" class="form-control" placeholder="Search events..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </form>
                    </div>

                    @if($events->isEmpty())
                        <div class="alert alert-info">
                            No reviews found. @if(request('search'))Try a different search term.@endif
                        </div>
                    @else
                        <div class="row">
                            @foreach($events as $event)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0">{{ $event->event_name }}</h5>
                                            <small class="text-muted">Organized by {{ $event->club_name }}</small>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div>
                                                    <span class="badge bg-primary">{{ $event->reviews->count() }} Reviews</span>
                                                    <span class="badge bg-success">Avg Rating: {{ number_format($event->averageRating(), 1) }}/5</span>
                                                </div>
                                                <a href="{{ route('reviews.show', $event) }}" class="btn btn-sm btn-primary">View Reviews</a>
                                            </div>
                                            <div class="reviews-preview">
                                                @foreach($event->reviews->take(2) as $review)
                                                    <div class="review-item mb-2 p-2 border rounded">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0">{{ $review->user->name }}</h6>
                                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                                        </div>
                                                        @if($review->rating)
                                                            <div class="rating">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                                @endfor
                                                            </div>
                                                        @endif
                                                        <p class="mb-0 text-truncate">{{ $review->comment }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 