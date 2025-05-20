@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-users-cog me-2"></i>
                        Club Members Management
                    </h3>
                </div>

                <div class="card-body">
                    @if($clubs->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No clubs found.
                        </div>
                    @else
                        @foreach($clubs as $club)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0">{{ $club->name }}</h4>
                                        <span class="badge bg-primary">
                                            {{ $club->members->count() }} Members
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Student ID</th>
                                                    <th>Email</th>
                                                    <th>Position</th>
                                                    <th>Joined Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($club->members as $member)
                                                    <tr>
                                                        <td>{{ $member->user->name }}</td>
                                                        <td>{{ $member->user->student_id }}</td>
                                                        <td>{{ $member->user->email }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $member->position === 'president' ? 'danger' : ($member->position === 'vice_president' ? 'warning' : ($member->position === 'general_secretary' ? 'success' : 'info')) }}">
                                                                {{ ucfirst(str_replace('_', ' ', $member->position)) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $member->joined_at->format('M d, Y') }}</td>
                                                        <td>
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
</style>
@endsection 