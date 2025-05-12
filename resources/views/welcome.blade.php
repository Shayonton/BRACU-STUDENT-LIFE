<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | BRAC UNIVERSITY STUDENT LIFE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background:rgb(2, 8, 26);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .hero-section {
            background: linear-gradient(rgba(78, 131, 223, 0.8), rgba(78, 115, 223, 0.8)), url('/images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-desc {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .features-section {
            padding: 4rem 0;
            background: white;
        }
        .feature-card {
            padding: 2rem;
            text-align: center;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 2rem;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #4e73df;
            margin-bottom: 1rem;
        }
        .cta-section {
            background: #4e73df;
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        .btn-custom {
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            margin: 0.5rem;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }
        .footer-link {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
        }
        .footer-link:hover {
            color:rgb(0, 206, 233);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Welcome to BRAC UNIVERSITY STUDENT LIFE</h1>
            <p class="hero-desc">Your one-stop platform for all student activities and events at BRAC University.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-light btn-custom">Login</a>
                <a href="{{ route('events.upcoming') }}" class="btn btn-outline-light btn-custom">Upcoming Events</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-calendar-alt feature-icon"></i>
                        <h3>Event Management</h3>
                        <p>Create, manage, and track all your university events in one place.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-users feature-icon"></i>
                        <h3>Student Engagement</h3>
                        <p>Connect with fellow students and participate in various activities.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-bell feature-icon"></i>
                        <h3>Real-time Updates</h3>
                        <p>Stay informed about upcoming events and important announcements.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Clubs Section -->
    <section class="clubs-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Our Clubs</h2>
            <div class="row">
                @foreach($clubs as $club)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if($club->logo)
                                <img src="{{ asset('storage/' . $club->logo) }}" class="card-img-top" alt="{{ $club->name }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $club->name }}</h5>
                                <p class="card-text">{{ Str::limit($club->description, 100) }}</p>
                                <a href="{{ route('clubs.show', $club) }}" class="btn btn-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('clubs.index') }}" class="btn btn-outline-primary">View All Clubs</a>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Get Started?</h2>
            <p class="mb-4">Join our community and make the most of your university experience.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register.student') }}" class="btn btn-light btn-custom">Register as Student</a>
                <a href="{{ route('register.club') }}" class="btn btn-outline-light btn-custom">Register as Club</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <div class="mb-3">
                <a href="/about" class="footer-link">About Us</a>
                <a href="/contact" class="footer-link">Contact</a>
                <a href="/privacy" class="footer-link">Privacy Policy</a>
                <a href="/terms" class="footer-link">Terms of Service</a>
            </div>
            <p>&copy; {{ date('Y') }} BRAC University Student Life. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
