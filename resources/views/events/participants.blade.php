@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        Participants for {{ $event->event_name }}
                    </h3>
                    <div>
                        <span class="badge bg-light text-dark fs-6">
                            Total: {{ $participants->count() }} Pre-registered
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    @if($participants->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No participants have pre-registered for this event yet.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Student ID</th>
                                        <th>Registration Status</th>
                                        <th>Registration Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->user->name }}</td>
                                            <td>{{ $participant->user->email }}</td>
                                            <td>{{ $participant->user->student_id ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ ucfirst($participant->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $participant->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <a href="mailto:{{ $participant->user->email }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-envelope me-1"></i>Email
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('events.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Events
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 