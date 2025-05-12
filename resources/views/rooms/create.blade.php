@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Book a Room</h3>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('rooms.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="event_id" class="form-label">Event</label>
                            <select class="form-control @error('event_id') is-invalid @enderror" id="event_id" name="event_id" required>
                                <option value="">Select an Event</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                        {{ $event->event_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="room_id" class="form-label">Room</label>
                            <select class="form-control @error('room_id') is-invalid @enderror" id="room_id" name="room_id" required>
                                <option value="">Select a Room</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_code }} - {{ $room->room_name }} (Capacity: {{ $room->capacity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="booking_date" class="form-label">Date</label>
                            <input type="date" class="form-control @error('booking_date') is-invalid @enderror" 
                                id="booking_date" name="booking_date" 
                                value="{{ old('booking_date') }}" 
                                min="{{ date('Y-m-d') }}" required>
                            @error('booking_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                        id="start_time" name="start_time" 
                                        value="{{ old('start_time') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                        id="end_time" name="end_time" 
                                        value="{{ old('end_time') }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Submit Booking Request</button>
                            <a href="{{ route('welcome') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 