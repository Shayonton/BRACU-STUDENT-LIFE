<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | BRAC UNIVERSITY STUDENT LIFE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #006B3F; /* BRAC Green */
            --primary-light: #008B4F;
            --primary-dark: #004B2F;
            --secondary: #FFFFFF;
            --accent: #FFD700; /* Gold accent */
            --accent-hover: #FFC800;
            --text-primary: #333333;
            --text-secondary: #666666;
            --card-bg: #FFFFFF;
            --card-hover: #F5F5F5;
            --gradient-start: rgba(0, 107, 63, 0.85);
            --gradient-end: rgba(0, 75, 47, 0.85);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 8px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 16px rgba(0,0,0,0.1);
        }

        body {
            background: var(--secondary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-primary);
            font-family: 'Roboto', sans-serif;
        }

        .hero-section {
            background: linear-gradient(var(--gradient-start), var(--gradient-end)), url('/images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: var(--secondary);
            padding: 6rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.3) 100%);
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                rgba(0, 107, 63, 0.85), 
                rgba(0, 75, 47, 0.85)
            );
            opacity: 1;
            animation: gradientShift 15s ease infinite;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            color: var(--secondary);
        }

        .hero-desc {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            color: var(--secondary);
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .btn-custom {
            padding: 0.8rem 2.5rem;
            font-size: 1.1rem;
            margin: 0.5rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        .btn-outline-light {
            border: 2px solid var(--secondary);
        }

        .btn-outline-light:hover {
            background: var(--secondary);
            color: var(--primary);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
            color: var(--primary);
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 60px;
            height: 4px;
            background: var(--accent);
            transform: translateX(-50%);
        }

        .section-title:hover::after {
            width: 100%;
        }

        .features-section {
            padding: 6rem 0;
            background: var(--secondary);
        }

        .feature-card {
            padding: 2.5rem;
            text-align: center;
            border-radius: 8px;
            background: var(--card-bg);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
            box-shadow: var(--shadow-sm);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .event-card {
            background: var(--card-bg);
            border: none;
            border-radius: 8px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .event-date {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .event-venue {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .clubs-section {
            background: #F5F5F5;
            padding: 6rem 0;
        }

        .club-card {
            background: var(--card-bg);
            border: none;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .club-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .club-card img {
            transition: transform 0.3s ease;
        }

        .club-card:hover img {
            transform: scale(1.05);
        }

        .club-card .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.7));
            opacity: 0;
            transition: 0.3s;
        }

        .club-card:hover .overlay {
            opacity: 1;
        }

        .club-card .club-info {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 1rem;
            color: white;
            transform: translateY(100%);
            transition: 0.3s;
        }

        .club-card:hover .club-info {
            transform: translateY(0);
        }

        .cta-section {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--secondary);
            padding: 6rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.2) 100%);
        }

        .footer {
            background: var(--primary-dark);
            color: var(--secondary);
            padding: 3rem 0;
            margin-top: auto;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            margin: 0 1rem;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--accent);
        }

        .card {
            background: var(--card-bg);
            border: none;
            color: var(--text-primary);
        }

        .card-title {
            color: var(--text-primary);
            font-weight: 600;
        }

        .card-text {
            color: var(--text-secondary);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--secondary);
        }

        .bg-light {
            background: #F5F5F5 !important;
        }

        /* Material Design Elevation */
        .elevation-1 { box-shadow: var(--shadow-sm); }
        .elevation-2 { box-shadow: var(--shadow-md); }
        .elevation-3 { box-shadow: var(--shadow-lg); }

        /* Material Design Ripple Effect */
        .ripple {
            position: relative;
            overflow: hidden;
        }

        .ripple:after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }

        .ripple:active:after {
            transform: scale(0, 0);
            opacity: .3;
            transition: 0s;
        }

        /* Material Design Input Fields */
        .form-control {
            border: none;
            border-bottom: 2px solid #ddd;
            border-radius: 0;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary);
        }

        /* Material Design Cards */
        .material-card {
            background: var(--card-bg);
            border-radius: 8px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .material-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        /* Material Design Buttons */
        .material-btn {
            border: none;
            border-radius: 4px;
            padding: 0.8rem 2rem;
            text-transform: uppercase;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .material-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Material Design Navigation */
        .material-nav {
            background: var(--primary);
            box-shadow: var(--shadow-md);
        }

        .material-nav-link {
            color: var(--secondary);
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .material-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Additional Dynamic Styles */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .counter {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary);
        }

        .stats-section {
            background: var(--secondary);
            padding: 4rem 0;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: var(--shadow-sm);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title" data-aos="fade-up">Welcome to BRAC UNIVERSITY STUDENT LIFE</h1>
            <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">Your one-stop platform for all student activities and events at BRAC University.</p>
            <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('login') }}" class="btn btn-light btn-custom">Login</a>
                <a href="{{ route('events.upcoming') }}" class="btn btn-outline-light btn-custom">Upcoming Events</a>
            </div>
            <div class="scroll-indicator">
                <i class="fas fa-chevron-down text-white"></i>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="stat-card">
                        <div class="counter" data-count="{{ $clubs->count() }}">0</div>
                        <p class="text-secondary">Active Clubs</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="counter" data-count="{{ $upcomingEvents->count() }}">0</div>
                        <p class="text-secondary">Upcoming Events</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-card">
                        <div class="counter" data-count="1000">0</div>
                        <p class="text-secondary">Active Students</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="upcoming-events-section py-5">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Upcoming Events</h2>
            <div class="row">
                @forelse($upcomingEvents as $event)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card event-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->event_name }}</h5>
                                <p class="event-date">
                                    <i class="fas fa-calendar-alt"></i> 
                                    {{ $event->event_date->format('F j, Y g:i A') }}
                                </p>
                                <p class="event-venue">
                                    <i class="fas fa-map-marker-alt"></i> {{ $event->venue }}
                                </p>
                                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                @auth
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-primary">View Details</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login to View Details</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p class="text-secondary">No upcoming events at the moment.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('events.upcoming') }}" class="btn btn-outline-primary">View All Events</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Why Choose Us</h2>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="feature-card">
                        <i class="fas fa-calendar-alt feature-icon floating"></i>
                        <h3>Event Management</h3>
                        <p class="text-secondary">Create, manage, and track all your university events in one place.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <i class="fas fa-users feature-icon floating"></i>
                        <h3>Student Engagement</h3>
                        <p class="text-secondary">Connect with fellow students and participate in various activities.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <i class="fas fa-bell feature-icon floating"></i>
                        <h3>Real-time Updates</h3>
                        <p class="text-secondary">Stay informed about upcoming events and important announcements.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Clubs Section -->
    <section class="clubs-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Our Clubs</h2>
            <div class="row">
                @foreach($clubs as $club)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card club-card">
                            @if($club->logo)
                                <img src="{{ asset('storage/' . $club->logo) }}" class="card-img-top" alt="{{ $club->name }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="overlay"></div>
                            <div class="club-info">
                                <h5 class="card-title">{{ $club->name }}</h5>
                                <p class="card-text">{{ Str::limit($club->description, 100) }}</p>
                                <a href="{{ route('clubs.show', $club) }}" class="btn btn-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('clubs.index') }}" class="btn btn-outline-primary">View All Clubs</a>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <h2 data-aos="fade-up">Ready to Get Started?</h2>
            <p class="mb-4" data-aos="fade-up" data-aos-delay="200">Join our community and make the most of your university experience.</p>
            <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="400">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-custom">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-custom">Login to Register</a>
                @endauth
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
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000; // 2 seconds
            const step = target / (duration / 16); // 60fps
            let current = 0;

            const updateCounter = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            // Start counter when element is in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            });

            observer.observe(counter);
        });

        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const hero = document.querySelector('.hero-section');
            const scrolled = window.pageYOffset;
            hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
        });
    </script>
</body>
</html>

