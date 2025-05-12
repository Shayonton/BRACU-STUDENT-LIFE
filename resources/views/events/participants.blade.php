@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Participants for {{ $event->event_name }}</h3>
                </div>

                <div class="card-body">
                    @if($participants->isEmpty())
                        <div class="alert alert-info">
                            No participants have pre-registered for this event yet.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registration Status</th>
                                        <th>Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->user->name }}</td>
                                            <td>{{ $participant->user->email }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ ucfirst($participant->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $participant->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('events.index') }}" class="btn btn-secondary">
                            Back to Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 