@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Contact Us</h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mb-5">
                        <div class="col-12 text-center mb-4">
                            <h4 class="text-primary">Meet Our Team</h4>
                            <p class="text-muted">The talented developers behind this platform</p>
                        </div>
                        @foreach($founders as $founder)
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div class="avatar-circle bg-primary text-white mx-auto">
                                                {{ substr($founder['name'], 0, 1) }}
                                            </div>
                                        </div>
                                        <h5 class="card-title text-primary">{{ $founder['name'] }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $founder['role'] }}</h6>
                                        <p class="card-text text-muted">{{ $founder['bio'] }}</p>
                                        <a href="mailto:{{ $founder['email'] }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-envelope"></i> Contact
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h4 class="text-center text-primary mb-4">Send us a Message</h4>
                                    <form method="POST" action="{{ route('contact.store') }}" class="needs-validation" novalidate>
                                        @csrf
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="type" class="form-label">Message Type</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                                    <option value="">Select type</option>
                                                    <option value="complaint" {{ old('type') == 'complaint' ? 'selected' : '' }}>Complaint</option>
                                                    <option value="suggestion" {{ old('type') == 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                                                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                @error('type')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="subject" class="form-label">Subject</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                                                @error('subject')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="message" class="form-label">Message</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                                @error('message')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="bi bi-send"></i> Send Message
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
    }
    
    .hover-shadow {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection 