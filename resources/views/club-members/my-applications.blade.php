@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Club Applications</h2>

    @if($applications->isEmpty())
        <div class="alert alert-info">
            You haven't applied to any clubs yet.
        </div>
    @else
        <div class="row">
            @foreach($applications as $application)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $application->club->name }}</h5>
                            <p class="card-text">
                                <strong>Status:</strong>
                                <span class="badge bg-{{ $application->status === 'pending' ? 'warning' : ($application->status === 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Application Note:</strong><br>
                                {{ $application->application_note }}
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Applied on: {{ $application->created_at->format('M d, Y') }}
                                </small>
                            </p>
                            @if($application->joined_at)
                                <p class="card-text">
                                    <small class="text-muted">
                                        Joined on: {{ $application->joined_at->format('M d, Y') }}
                                    </small>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection 