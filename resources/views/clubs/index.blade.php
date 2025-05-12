@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Clubs</h2>
                </div>

                <div class="card-body">
                    <div class="row">
                        @forelse ($clubs as $club)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    @if($club->logo)
                                        <img src="{{ asset('storage/' . $club->logo) }}" class="card-img-top" alt="{{ $club->name }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $club->name }}</h5>
                                        <p class="card-text">{{ Str::limit($club->description, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('clubs.show', $club) }}" class="btn btn-primary">View Details</a>
                                            @if($club->website)
                                                <a href="{{ $club->website }}" target="_blank" class="btn btn-outline-secondary">Website</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center">No clubs found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 