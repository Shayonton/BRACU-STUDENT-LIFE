<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BRAC UNIVERSITY STUDENT LIFE') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Add Font Awesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background: linear-gradient(180deg, var(--primary-color) 0%, #224abe 100%);
            padding-top: 20px;
            transition: all 0.3s;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            z-index: 1000;
        }

        .sidebar-brand {
            font-weight: 800;
            font-size: 0.9rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
            line-height: 1.2;
            padding: 1rem !important;
        }

        .sidebar.collapsed {
            width: 0;
        }

        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #fff;
        }

        .sidebar a.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #fff;
        }

        .toggle-sidebar {
            cursor: pointer;
            padding: 15px;
            color: #fff;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.35rem;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }

        .alert {
            border: none;
            border-radius: 0.35rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            background-color: #f8f9fc;
            color: var(--secondary-color);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
        }

        .badge {
            padding: 0.5em 0.75em;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar.collapsed {
                width: 250px;
            }
            .main-content.expanded {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="toggle-sidebar" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </div>
        <div class="sidebar-brand p-3 text-white">
            <i class="bi bi-calendar-event me-2"></i>
            @auth
                {{ auth()->user()->name }}
                @if(auth()->user()->isStudent())
                    <small class="text-light">(Student)</small>
                @elseif(auth()->user()->isClub())
                    <small class="text-light">(Club)</small>
                @endif
            @else
                BRAC UNIVERSITY STUDENT LIFE
            @endauth
        </div>
        <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
            <i class="bi bi-house-door me-2"></i> Home
        </a>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        @if(auth()->check() && auth()->user()->user_type === 'club')
        <a href="{{ route('club.dashboard') }}" class="{{ request()->routeIs('club.dashboard') ? 'active' : '' }}">
            <i class="bi bi-people me-2"></i> Club Dashboard
        </a>
        @endif
        <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">
            <i class="bi bi-person me-2"></i> Profile
        </a>
        <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">
            <i class="bi bi-door-open me-2"></i> Room Booking
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="bi bi-gear me-2"></i> Settings
        </a>
        <a href="{{ route('contact.index') }}" class="{{ request()->routeIs('contact.*') ? 'active' : '' }}">
            <i class="bi bi-envelope me-2"></i> Contact Us
        </a>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('events.index') }}">Events</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('reviews.index') }}">Reviews</a>
        </li>
        <a href="{{ route('clubs.index') }}" class="{{ request()->routeIs('clubs.*') ? 'active' : '' }}">
            <i class="bi bi-people me-2"></i> Clubs
        </a>
        @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </form>
        @endauth
    </div>

    <div class="main-content" id="mainContent">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <i class="bi bi-calendar-event me-2"></i>
                    {{ config('app.name', 'BRAC UNIVERSITY STUDENT LIFE') }}
                </span>
                @auth
                    <div class="d-flex align-items-center">
                        <span class="me-3 text-primary">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->name }}
                            @if(auth()->user()->isStudent())
                                <small class="text-muted">(Student)</small>
                            @elseif(auth()->user()->isClub())
                                <small class="text-muted">(Club)</small>
                            @endif
                        </span>
                    </div>
                @endauth
            </div>
        </nav>

        <main class="container py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        // Add active class to current route
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const links = document.querySelectorAll('.sidebar a');
            links.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 