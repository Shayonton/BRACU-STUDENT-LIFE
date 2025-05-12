@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Pending Applications</h2>

    @if($applications->isEmpty())
        <div class="alert alert-info">
            There are no pending applications.
        </div>
    @else
        <div class="row">
            @foreach($applications as $application)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $application->user->name }}</h5>
                            <p class="card-text">
                                <strong>Student ID:</strong> {{ $application->user->student_id }}
                            </p>
                            <p class="card-text">
                                <strong>Email:</strong> {{ $application->user->email }}
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
                            <div class="mt-3">
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
        </div>
    @endif
</div>
@endsection 