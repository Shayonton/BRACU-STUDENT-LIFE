@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ $club->name }} Dashboard</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Club Information</h4>
                            <p><strong>Email:</strong> {{ $club->email }}</p>
                            <p><strong>Phone:</strong> {{ $club->phone }}</p>
                            <p><strong>Description:</strong> {{ $club->description }}</p>
                            @if($club->website)
                                <p><strong>Website:</strong> <a href="{{ $club->website }}" target="_blank">{{ $club->website }}</a></p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h4>Quick Stats</h4>
                            <p><strong>Pending Applications:</strong> {{ $pendingApplications->count() }}</p>
                            <p><strong>Total Members:</strong> {{ $approvedMembers->count() }}</p>
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
            </div>
        </div>

        <!-- Approved Members -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Club Members</h3>
                </div>
                <div class="card-body">
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
                                        <th>Promote</th>
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
                                                @php
                                                    $clubAdminRoles = ['general_member' => 'General Member', 'executive' => 'Executive', 'director' => 'Director'];
                                                    $adminRoles = ['president' => 'President', 'vice_president' => 'Vice President', 'general_secretary' => 'General Secretary', 'treasurer' => 'Treasurer'];
                                                    $canPromote = false;
                                                    if(auth()->user()->isAdmin()) {
                                                        $roles = $adminRoles;
                                                        $canPromote = true;
                                                    } elseif(auth()->user()->user_type === 'club' && auth()->user()->email === $club->email) {
                                                        $roles = $clubAdminRoles;
                                                        $canPromote = true;
                                                    } else {
                                                        $roles = [];
                                                    }
                                                @endphp
                                                @if($canPromote)
                                                <form action="{{ route('members.promote', $member) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <select name="position" class="form-select form-select-sm d-inline w-auto" required>
                                                        <option value="">Promote to...</option>
                                                        @foreach($roles as $key => $label)
                                                            <option value="{{ $key }}" @if($member->position === $key) selected @endif>{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary">Promote</button>
                                                </form>
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
</div>
@endsection 