@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Upcoming Events Section -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        @if(auth()->user()->isAdmin())
                            All Events
                        @elseif(auth()->user()->isStudent())
                            Available Events
                        @else
                            My Events
                        @endif
                    </h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(auth()->user()->isClub())
                        <div class="mb-4">
                            <a href="{{ route('events.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create New Event
                            </a>
                        </div>
                    @endif

                    @if($events->isEmpty())
                        <div class="alert alert-info">
                            @if(auth()->user()->isAdmin())
                                No events have been created yet.
                            @elseif(auth()->user()->isStudent())
                                No upcoming events are available at the moment.
                            @else
                                You haven't created any events yet.
                            @endif
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Club</th>
                                        <th>Date</th>
                                        <th>Venue</th>
                                        <th>Description</th>
                                        @if(!auth()->user()->isStudent())
                                            <th>Status</th>
                                        @endif
                                        @if(auth()->user()->isStudent())
                                            <th>Registration</th>
                                        @endif
                                        @if(auth()->user()->isAdmin() || auth()->user()->isClub())
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{ $event->event_name }}</td>
                                            <td>{{ $event->club_name }}</td>
                                            <td>{{ $event->event_date->format('M d, Y') }}</td>
                                            <td>{{ $event->venue }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#descriptionModal{{ $event->id }}">
                                                    <i class="fas fa-info-circle me-1"></i>View Description
                                                </button>
                                                <!-- Description Modal -->
                                                <div class="modal fade" id="descriptionModal{{ $event->id }}" tabindex="-1" aria-labelledby="descriptionModalLabel{{ $event->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title" id="descriptionModalLabel{{ $event->id }}">{{ $event->event_name }} Description</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $event->description }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            @if(!auth()->user()->isStudent())
                                                <td>
                                                    <span class="badge bg-{{ $event->status === 'approved' ? 'success' : ($event->status === 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($event->status) }}
                                                    </span>
                                                </td>
                                            @endif
                                            @if(auth()->user()->isStudent())
                                                <td>
                                                    @if($event->participants()->where('user_id', auth()->id())->exists())
                                                        <a href="{{ $event->registration_form_link }}" target="_blank" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-user-plus me-1"></i>Register
                                                        </a>
                                                        <span class="badge bg-success">Pre-Registered</span>
                                                    @else
                                                        <form action="{{ route('events.pre-register', $event) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fas fa-clipboard-list me-1"></i>Pre-Register
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if($event->event_link)
                                                        <a href="{{ $event->event_link }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                            <i class="fas fa-external-link-alt me-1"></i>Event Page
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif
                                            @if(auth()->user()->isAdmin())
                                                <td>
                                                    <a href="{{ route('events.participants', $event) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-users me-1"></i>View Participants
                                                    </a>
                                                    @if($event->status === 'pending')
                                                        <form action="{{ route('events.approve', $event) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fas fa-check me-1"></i>Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('events.reject', $event) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-times me-1"></i>Reject
                                                            </button>
                                                        </form>
                                                    @elseif($event->status === 'approved')
                                                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash me-1"></i>Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            @elseif(auth()->user()->isClub())
                                                <td>
                                                    <a href="{{ route('events.participants', $event) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-users me-1"></i>View Participants
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Registered Events Section -->
            @if(auth()->user()->isStudent())
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0">
                            <i class="fas fa-clipboard-check me-2"></i>
                            My Registered Events
                        </h3>
                    </div>

                    <div class="card-body">
                        @if($events->filter(function($event) {
                            return $event->participants()->where('user_id', auth()->id())->exists();
                        })->isEmpty())
                            <div class="alert alert-info">
                                You haven't registered for any events yet.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Event Name</th>
                                            <th>Club</th>
                                            <th>Date</th>
                                            <th>Venue</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($events->filter(function($event) {
                                            return $event->participants()->where('user_id', auth()->id())->exists();
                                        }) as $event)
                                            <tr>
                                                <td>{{ $event->event_name }}</td>
                                                <td>{{ $event->club_name }}</td>
                                                <td>{{ $event->event_date->format('M d, Y') }}</td>
                                                <td>{{ $event->venue }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#descriptionModal{{ $event->id }}">
                                                        <i class="fas fa-info-circle me-1"></i>View Description
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="{{ $event->registration_form_link }}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-user-plus me-1"></i>Register
                                                    </a>
                                                    @if($event->event_link)
                                                        <a href="{{ $event->event_link }}" target="_blank" class="btn btn-sm btn-info">
                                                            <i class="fas fa-external-link-alt me-1"></i>Event Page
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="card shadow-lg">
                    <div class="card-header bg-warning text-white">
                        <h3 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            Event Reviews
                        </h3>
                    </div>

                    <div class="card-body">
                        @if($events->filter(function($event) {
                            return $event->participants()->where('user_id', auth()->id())->exists();
                        })->isEmpty())
                            <div class="alert alert-info">
                                You haven't registered for any events yet. Register for events to leave reviews.
                            </div>
                        @else
                            @foreach($events as $event)
                                @if($event->participants()->where('user_id', auth()->id())->exists())
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">{{ $event->event_name }}</h5>
                                                @if($event->reviews->isNotEmpty())
                                                    <small class="text-muted">
                                                        <i class="fas fa-star text-warning"></i>
                                                        Average Rating: {{ number_format($event->averageRating(), 1) }}/5
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if(!$event->reviews()->where('user_id', auth()->id())->exists())
                                                <form action="{{ route('reviews.store', $event) }}" method="POST" class="mb-3">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label rating-label">Rating (1-5)</label>
                                                        <div class="rating-container">
                                                            <div class="rating-input">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star rating-star" data-rating="{{ $i }}"></i>
                                                                @endfor
                                                                <input type="hidden" name="rating" id="rating" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="comment" class="form-label">Comment</label>
                                                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-paper-plane me-1"></i>Submit Review
                                                    </button>
                                                </form>
                                            @endif

                                            @if($event->reviews->isNotEmpty())
                                                <div class="reviews-list">
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
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        <i class="fas fa-trash me-1"></i>Delete
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted">No reviews yet. Be the first to review this event!</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .rating-input {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .rating-star {
        font-size: 1.5rem;
        cursor: pointer;
        color: #ddd;
        transition: color 0.2s;
    }
    .rating-star:hover,
    .rating-star.active {
        color: #ffc107 !important;
    }
    .rating-container {
        margin-bottom: 1.5rem;
        padding: 0.5rem;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
    }
    .rating-label {
        margin-bottom: 0.5rem;
        display: block;
        font-weight: 500;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Rating star functionality
        document.querySelectorAll('.rating-star').forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                const container = this.parentElement;
                const input = container.querySelector('input[name="rating"]');
                
                // Update input value
                input.value = rating;
                
                // Update star colors
                container.querySelectorAll('.rating-star').forEach(s => {
                    if (s.dataset.rating <= rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });
    });
</script>
@endsection 