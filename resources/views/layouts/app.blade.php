<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PetPal') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('petpal-paw.svg') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap and Custom Assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #f9fafb;
        }

        /* Fix content under fixed navbar */
        main {
            padding-top: 90px;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: #6C63FF !important;
            font-size: 1.4rem;
        }

        .nav-link {
            font-weight: 500;
        }

        .btn-primary-custom {
            background-color: #6C63FF;
            color: #fff;
            border-radius: 50px;
            padding: 8px 22px;
            border: none;
        }

        .btn-primary-custom:hover {
            background-color: #5a52d5;
            color: #fff;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- 🔥 COMMON NAVBAR (SAME AS DASHBOARD) -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-paw me-2"></i>PetPal
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    @auth
                        @if(auth()->user()->role === 'service_provider')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('service-provider.dashboard') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('service-provider.services.index') }}">My Services</a>
                            </li>
                        @elseif(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/#services') }}">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/#about') }}">About</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/#services') }}">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/#about') }}">About</a>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="nav-link">
                                Log in
                            </a>
                        </li>

                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('register') }}"
                               class="btn btn-primary-custom">
                                Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle fw-semibold"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                               <li>
    <button type="button"
            class="dropdown-item text-danger"
            data-bs-toggle="modal"
            data-bs-target="#navbarLogoutModal">
        <i class="fas fa-sign-out-alt me-2"></i>
        Logout
    </button>
</li>

                            </ul>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main>
        @yield('content')
    </main>

    @stack('scripts')

    @stack('scripts')
    <!-- NAVBAR LOGOUT CONFIRMATION MODAL -->
<div class="modal fade" id="navbarLogoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Confirm Logout</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="text-muted mb-0">
                    Are you sure you want to log out?
                </p>
            </div>

            <div class="modal-footer border-0 justify-content-center gap-2">
                <button type="button"
                        class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-danger rounded-pill px-4">
                        Log out
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

</body>
</html>
