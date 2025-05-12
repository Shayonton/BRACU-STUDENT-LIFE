@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">{{ $event->event_name }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="text-muted">Event Details</h5>
                        <p><strong>Club:</strong> {{ $event->club_name }}</p>
                        <p><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</p>
                        <p><strong>Venue:</strong> {{ $event->venue }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $event->status === 'approved' ? 'success' : ($event->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-muted">Description</h5>
                        <p>{{ $event->description }}</p>
                    </div>

                    @if($event->needs_stalls)
                    <div class="mb-4">
                        <h5 class="text-muted">Stall Information</h5>
                        <p><strong>Number of Stalls:</strong> {{ $event->number_of_stalls }}</p>
                    </div>
                    @endif

                    <div class="mb-4">
                        <h5 class="text-muted">Links</h5>
                        <p><strong>Registration Form:</strong> <a href="{{ $event->registration_form_link }}" target="_blank">Click here to register</a></p>
                        @if($event->event_link)
                            <p><strong>Event Link:</strong> <a href="{{ $event->event_link }}" target="_blank">Event Details</a></p>
                        @endif
                    </div>

                    @if(auth()->user()->isStudent() && $event->status === 'approved')
                        <div class="mt-4">
                            <form action="{{ route('events.pre-register', $event) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Pre-register for Event</button>
                            </form>
                        </div>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <div class="mt-4">
                            @if($event->status === 'pending')
                                <form action="{{ route('events.approve', $event) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve Event</button>
                                </form>
                                <form action="{{ route('events.reject', $event) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject Event</button>
                                </form>
                            @endif
                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete Event</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 