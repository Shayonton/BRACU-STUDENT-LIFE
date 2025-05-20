@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        My Club Memberships
                    </h3>
                </div>

                <div class="card-body">
                    @if($clubMemberships->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            You are not a member of any clubs yet.
                            <a href="{{ route('clubs.index') }}" class="alert-link">Browse available clubs</a>
                        </div>
                    @else
                        @foreach($clubMemberships as $membership)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0">{{ $membership->club->name }}</h4>
                                        <span class="badge bg-primary">
                                            {{ ucfirst(str_replace('_', ' ', $membership->position)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Club Members</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Student ID</th>
                                                    <th>Position</th>
                                                    <th>Joined Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($membership->club->members as $member)
                                                    <tr class="{{ $member->user_id === auth()->id() ? 'table-primary' : '' }}">
                                                        <td>
                                                            {{ $member->user->name }}
                                                            @if($member->user_id === auth()->id())
                                                                <span class="badge bg-info">You</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $member->user->student_id }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $member->position === 'president' ? 'danger' : ($member->position === 'vice_president' ? 'warning' : ($member->position === 'general_secretary' ? 'success' : 'info')) }}">
                                                                {{ ucfirst(str_replace('_', ' ', $member->position)) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $member->joined_at->format('M d, Y') }}</td>
                                                        <td>
                                                            @if(auth()->user()->isAdmin())
                                                                <form action="{{ route('members.promote', $member) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <select name="position" class="form-select form-select-sm d-inline-block w-auto">
                                                                        <option value="president">President</option>
                                                                        <option value="vice_president">Vice President</option>
                                                                        <option value="general_secretary">General Secretary</option>
                                                                        <option value="treasurer">Treasurer</option>
                                                                        <option value="director">Director</option>
                                                                        <option value="executive">Executive</option>
                                                                        <option value="general_member">General Member</option>
                                                                    </select>
                                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                                        <i class="bi bi-arrow-up"></i> Promote
                                                                    </button>
                                                                </form>
                                                            @elseif(auth()->user()->user_type === 'club')
                                                                <form action="{{ route('members.promote', $member) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <select name="position" class="form-select form-select-sm d-inline-block w-auto">
                                                                        <option value="director">Director</option>
                                                                        <option value="executive">Executive</option>
                                                                        <option value="general_member">General Member</option>
                                                                    </select>
                                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                                        <i class="bi bi-arrow-up"></i> Promote
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .badge {
        font-size: 0.85em;
    }
    .table-primary {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
</style>
@endsection 