@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </h3>
                </div>

                <div class="card-body">
                    @if(auth()->user()->isStudent())
                        <!-- Club Memberships Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">
                                        <i class="fas fa-users me-2"></i>
                                        My Club Memberships
                                    </h4>
                                    <a href="{{ route('my.clubs') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        View All Memberships
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @php
                                    $clubMemberships = auth()->user()->clubMemberships()
                                        ->where('status', 'approved')
                                        ->with('club')
                                        ->latest()
                                        ->take(3)
                                        ->get();
                                @endphp

                                @if($clubMemberships->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        You are not a member of any clubs yet.
                                        <a href="{{ route('clubs.index') }}" class="alert-link">Browse available clubs</a>
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach($clubMemberships as $membership)
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $membership->club->name }}</h5>
                                                        <p class="card-text">
                                                            <span class="badge bg-primary">
                                                                {{ ucfirst(str_replace('_', ' ', $membership->position)) }}
                                                            </span>
                                                        </p>
                                                        <p class="card-text">
                                                            <small class="text-muted">
                                                                Joined: {{ $membership->joined_at->format('M d, Y') }}
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->user_type === 'club')
                        <!-- Club Dashboard Section -->
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="mb-0 d-flex justify-content-between align-items-center">
                                            {{ auth()->user()->name }} Dashboard
                                            <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm ms-3">
                                                <i class="bi bi-plus-lg me-1"></i> Create Event
                                            </a>
                                        </h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Club Information</h4>
                                                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                                <p><strong>Phone:</strong> {{ auth()->user()->phone_number }}</p>
                                                @if(auth()->user()->profile)
                                                    <p><strong>Description:</strong> {{ auth()->user()->profile->club_description }}</p>
                                                    @if(auth()->user()->profile->club_website)
                                                        <p><strong>Website:</strong> <a href="{{ auth()->user()->profile->club_website }}" target="_blank">{{ auth()->user()->profile->club_website }}</a></p>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <h4>Quick Stats</h4>
                                                @php
                                                    $club = \App\Models\Club::where('email', auth()->user()->email)->first();
                                                    $pendingApplications = $club ? \App\Models\ClubMember::where('club_id', $club->id)
                                                        ->where('status', 'pending')
                                                        ->count() : 0;
                                                    $approvedMembers = $club ? \App\Models\ClubMember::where('club_id', $club->id)
                                                        ->where('status', 'approved')
                                                        ->count() : 0;
                                                @endphp
                                                <p><strong>Pending Applications:</strong> {{ $pendingApplications }}</p>
                                                <p><strong>Total Members:</strong> {{ $approvedMembers }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Applications -->
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">Pending Applications</h3>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $pendingApplications = $club ? \App\Models\ClubMember::where('club_id', $club->id)
                                                ->where('status', 'pending')
                                                ->with('user')
                                                ->latest()
                                                ->get() : collect();
                                        @endphp

                                        @if($pendingApplications->isEmpty())
                                            <div class="alert alert-info">
                                                No pending applications at the moment.
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Student Name</th>
                                                            <th>Student ID</th>
                                                            <th>Email</th>
                                                            <th>Applied On</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($pendingApplications as $application)
                                                            <tr>
                                                                <td>{{ $application->user->name }}</td>
                                                                <td>{{ $application->user->student_id }}</td>
                                                                <td>{{ $application->user->email }}</td>
                                                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                                                <td>
                                                                    <form action="{{ route('members.approve', $application) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-success btn-sm">
                                                                            <i class="bi bi-check-lg"></i> Approve
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('members.reject', $application) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                            <i class="bi bi-x-lg"></i> Reject
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Approved Members -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">Club Members</h3>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $approvedMembers = $club ? \App\Models\ClubMember::where('club_id', $club->id)
                                                ->where('status', 'approved')
                                                ->with('user')
                                                ->latest()
                                                ->get() : collect();
                                        @endphp

                                        @if($approvedMembers->isEmpty())
                                            <div class="alert alert-info">
                                                No members yet.
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Student Name</th>
                                                            <th>Student ID</th>
                                                            <th>Email</th>
                                                            <th>Joined On</th>
                                                            <th>Position</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($approvedMembers as $member)
                                                            <tr>
                                                                <td>{{ $member->user->name }}</td>
                                                                <td>{{ $member->user->student_id }}</td>
                                                                <td>{{ $member->user->email }}</td>
                                                                <td>{{ $member->joined_at->format('M d, Y') }}</td>
                                                                <td>{{ ucfirst(str_replace('_', ' ', $member->position ?? 'General Member')) }}</td>
                                                                <td>
                                                                    <form action="{{ route('members.promote', $member) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <select name="position" class="form-select form-select-sm d-inline-block w-auto">
                                                                            <option value="general_member">General Member</option>
                                                                            <option value="executive">Executive</option>
                                                                            <option value="director">Director</option>
                                                                        </select>
                                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                                            <i class="bi bi-arrow-up"></i> Promote
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('members.remove', $member) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this member?')">
                                                                            <i class="bi bi-person-x"></i> Remove
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Events Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Recent Events</h6>
                                    @if(auth()->user()->user_type === 'club')
                                        <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-2"></i>Create Event
                                        </a>
                                    @endif
                                </div>
                                <div class="card-body">
                                    @if($events->isEmpty())
                                        <div class="alert alert-info">
                                            No events found.
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Event Name</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($events as $event)
                                                        <tr>
                                                            <td>{{ $event->event_name }}</td>
                                                            <td>{{ $event->event_date->format('M d, Y') }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $event->status === 'approved' ? 'success' : ($event->status === 'pending' ? 'warning' : 'danger') }}">
                                                                    {{ ucfirst($event->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('events.show', $event) }}" class="btn btn-info btn-sm">
                                                                    <i class="bi bi-eye"></i> View
                                                                </a>
                                                                @if($event->status === 'approved')
                                                                    <a href="{{ route('events.participants', $event) }}" class="btn btn-primary btn-sm">
                                                                        <i class="bi bi-people"></i> Participants
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
                        </div>
                    </div>

                    @if(auth()->user()->isAdmin())
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-header bg-primary text-white">
                                        <h4 class="mb-0">
                                            <i class="fas fa-cog me-2"></i>
                                            Admin Controls
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <a href="{{ route('admin.club-members.index') }}" class="btn btn-primary w-100">
                                                    <i class="fas fa-users-cog me-2"></i>
                                                    Manage Club Members
                                                </a>
                                            </div>
                                            <!-- Add more admin controls here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 