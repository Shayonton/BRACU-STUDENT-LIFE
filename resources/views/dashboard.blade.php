@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Events</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEvents }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-event fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Upcoming Events</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingEvents }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pending Events</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingEvents }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock-history fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Your Events</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userEvents }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-badge fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Events</h6>
                @if(auth()->user()->user_type === 'club_representative')
                    <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-2"></i>Create Event
                    </a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr>
                                    <td>{{ $event->event_name }}</td>
                                    <td>{{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('M d, Y') : 'No date set' }}</td>
                                    <td>
                                        {{ $event->room ? $event->room->room_code : ($event->location ?? 'Not set') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $event->status === 'approved' ? 'success' : ($event->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('events.show', $event) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->user_type === 'club_representative' && $event->user_id === auth()->id())
                                            <a href="{{ route('events.edit', $event) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No events found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.club-memberships')

<style>
    .border-left-primary {
        border-left: 4px solid var(--primary-color) !important;
    }
    .border-left-success {
        border-left: 4px solid var(--success-color) !important;
    }
    .border-left-info {
        border-left: 4px solid var(--info-color) !important;
    }
    .border-left-warning {
        border-left: 4px solid var(--warning-color) !important;
    }
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection 