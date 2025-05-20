@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ $club->name }}</h2>
                </div>

                <div class="card-body">
                    @if($club->logo)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $club->logo) }}" alt="{{ $club->name }}" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    @endif

                    <div class="mb-4">
                        <h4>About</h4>
                        <p>{{ $club->description }}</p>
                    </div>

                    <div class="row">
                        @if($club->email)
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong>
                                <p>{{ $club->email }}</p>
                            </div>
                        @endif

                        @if($club->phone)
                            <div class="col-md-6 mb-3">
                                <strong>Phone:</strong>
                                <p>{{ $club->phone }}</p>
                            </div>
                        @endif

                        @if($club->location)
                            <div class="col-md-6 mb-3">
                                <strong>Location:</strong>
                                <p>{{ $club->location }}</p>
                            </div>
                        @endif

                        @if($club->website)
                            <div class="col-md-6 mb-3">
                                <strong>Website:</strong>
                                <p><a href="{{ $club->website }}" target="_blank">{{ $club->website }}</a></p>
                            </div>
                        @endif
                    </div>

                    @auth
                        @if(auth()->user()->user_type === 'student')
                            @php
                                $existingMembership = \App\Models\ClubMember::where('user_id', auth()->id())
                                    ->where('club_id', $club->id)
                                    ->first();
                            @endphp

                            @if($existingMembership && $existingMembership->status === 'approved')
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    You are a member of this club.
                                </div>
                            @elseif($existingMembership && $existingMembership->status === 'pending')
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-clock me-2"></i>
                                    Your application is pending review.
                                </div>
                            @elseif($existingMembership && $existingMembership->status === 'rejected')
                                <div class="alert alert-danger mt-3">
                                    <i class="fas fa-times-circle me-2"></i>
                                    Your previous application was rejected. You can apply again.
                                </div>
                                <form action="{{ route('clubs.apply', $club) }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="application_note" class="form-label">Why do you want to join this club?</label>
                                        <textarea name="application_note" id="application_note" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Apply Again</button>
                                </form>
                            @else
                                <form action="{{ route('clubs.apply', $club) }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="application_note" class="form-label">Why do you want to join this club?</label>
                                        <textarea name="application_note" id="application_note" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Apply to Join</button>
                                </form>
                            @endif
                        @endif

                        @if(auth()->user()->user_type === 'club' && auth()->user()->email === $club->email)
                            <div class="mt-4">
                                <h4>Club Applications</h4>
                                @php
                                    $pendingApplications = \App\Models\ClubMember::where('club_id', $club->id)
                                        ->where('status', 'pending')
                                        ->with('user')
                                        ->get();
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
                                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#applicationModal{{ $application->id }}">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <!-- Application Details Modal -->
                                                    <div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Application Details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Student Name:</strong> {{ $application->user->name }}</p>
                                                                    <p><strong>Student ID:</strong> {{ $application->user->student_id }}</p>
                                                                    <p><strong>Email:</strong> {{ $application->user->email }}</p>
                                                                    <p><strong>Application Note:</strong></p>
                                                                    <p>{{ $application->application_note }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('members.approve', $application) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-success">Approve</button>
                                                                    </form>
                                                                    <form action="{{ route('members.reject', $application) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-danger">Reject</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <div class="mt-4">
                        <a href="{{ route('clubs.index') }}" class="btn btn-secondary">Back to Clubs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 