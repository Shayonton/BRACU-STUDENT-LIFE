@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Event') }}</div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('events.store') }}" id="eventForm">
                        @csrf

                        <div class="mb-3">
                            <label for="event_name" class="form-label">{{ __('Event Name') }}</label>
                            <input id="event_name" type="text" class="form-control @error('event_name') is-invalid @enderror" name="event_name" value="{{ old('event_name') }}" required autofocus>
                            @error('event_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="club_name" class="form-label">{{ __('Club Name') }}</label>
                            <input id="club_name" type="text" class="form-control @error('club_name') is-invalid @enderror" name="club_name" value="{{ old('club_name') }}" required>
                            @error('club_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="event_date" class="form-label">{{ __('Event Date and Time') }}</label>
                            <input id="event_date" type="datetime-local" class="form-control @error('event_date') is-invalid @enderror" name="event_date" value="{{ old('event_date') }}" required>
                            @error('event_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="venue" class="form-label">{{ __('Venue') }}</label>
                            <input id="venue" type="text" class="form-control @error('venue') is-invalid @enderror" name="venue" value="{{ old('venue') }}" required>
                            @error('venue')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Event Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="text-muted">Provide a detailed description of your event, including its purpose, activities, and any other relevant information.</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="needs_stalls" id="needs_stalls" value="1" {{ old('needs_stalls') ? 'checked' : '' }}>
                                <label class="form-check-label" for="needs_stalls">
                                    {{ __('Needs Stalls') }} <small class="text-muted">(Optional)</small>
                                </label>
                            </div>
                        </div>

                        <div class="mb-3" id="stalls_number_container" style="display: none;">
                            <label for="number_of_stalls" class="form-label">{{ __('Number of Stalls') }} <small class="text-muted">(Optional)</small></label>
                            <input id="number_of_stalls" type="number" class="form-control @error('number_of_stalls') is-invalid @enderror" name="number_of_stalls" value="{{ old('number_of_stalls') }}" min="1">
                            @error('number_of_stalls')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="registration_form_link" class="form-label">{{ __('Registration Form Link') }}</label>
                            <input id="registration_form_link" type="url" class="form-control @error('registration_form_link') is-invalid @enderror" name="registration_form_link" value="{{ old('registration_form_link') }}" required>
                            @error('registration_form_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="event_link" class="form-label">{{ __('Event Page Link') }}</label>
                            <input id="event_link" type="url" class="form-control @error('event_link') is-invalid @enderror" name="event_link" value="{{ old('event_link') }}" placeholder="Optional">
                            @error('event_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="text-muted">Provide a link to your event's webpage or social media page (optional)</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="submitButton">
                                {{ __('Create Event') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const needsStallsCheckbox = document.getElementById('needs_stalls');
        const stallsContainer = document.getElementById('stalls_number_container');
        
        // Show/hide stalls number input based on checkbox
        needsStallsCheckbox.addEventListener('change', function() {
            stallsContainer.style.display = this.checked ? 'block' : 'none';
        });

        // Initialize stalls container visibility
        stallsContainer.style.display = needsStallsCheckbox.checked ? 'block' : 'none';

        // Form submission handling
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Creating Event...';
        });
    });
</script>
@endsection 