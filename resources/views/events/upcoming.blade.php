<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events | BRAC University Student Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fc;
        }
        .event-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 2rem;
            transition: transform 0.2s;
        }
        .event-card:hover {
            transform: translateY(-5px);
        }
        .event-header {
            background: #4e73df;
            color: white;
            padding: 1rem;
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .event-date {
            font-size: 0.9rem;
            color: #858796;
        }
        .event-venue {
            color: #4e73df;
            font-weight: 500;
        }
        .event-stalls {
            background: #f8f9fc;
            padding: 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.9rem;
        }
        .page-title {
            color: #4e73df;
            margin-bottom: 2rem;
            font-weight: 700;
        }
        .no-events {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="page-title">Upcoming Events</h1>

        @if($events->isEmpty())
            <div class="no-events">
                <i class="fas fa-calendar-times fa-3x mb-3" style="color: #4e73df;"></i>
                <h3>No Upcoming Events</h3>
                <p class="text-muted">Check back later for new events!</p>
            </div>
        @else
            <div class="row">
                @foreach($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="event-card">
                            <div class="event-header">
                                <h5 class="mb-0">{{ $event->event_name }}</h5>
                                <small>Organized by {{ $event->club_name }}</small>
                            </div>
                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="event-date">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $event->event_date->format('F j, Y') }}
                                    </div>
                                    @if($event->needs_stalls)
                                        <div class="event-stalls">
                                            <i class="fas fa-store me-1"></i>
                                            {{ $event->number_of_stalls }} Stalls
                                        </div>
                                    @endif
                                </div>
                                <div class="event-venue mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $event->venue }}
                                </div>
                                <div class="event-description mb-3">
                                    <p class="text-muted">{{ Str::limit($event->description, 150) }}</p>
                                    <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="modal" data-bs-target="#descriptionModal{{ $event->id }}">
                                        Read More
                                    </button>
                                </div>
                                <!-- Description Modal -->
                                <div class="modal fade" id="descriptionModal{{ $event->id }}" tabindex="-1" aria-labelledby="descriptionModalLabel{{ $event->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="descriptionModalLabel{{ $event->id }}">{{ $event->event_name }} Description</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <div class="d-grid gap-2">
                                    @auth
                                        <a href="{{ $event->registration_form_link }}" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-user-plus me-1"></i> Register Now
                                        </a>
                                        @if(auth()->user()->isStudent())
                                            <form action="{{ route('events.pre-register', $event) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary w-100">
                                                    <i class="fas fa-clipboard-list me-1"></i> Pre-register
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt me-1"></i> Login to Register
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 