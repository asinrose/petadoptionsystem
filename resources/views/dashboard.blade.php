
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PetPal') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('petpal-paw.svg') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #6C63FF;
            --secondary-color: #F8F9FA;
            --accent-color: #FF6584;
            --text-dark: #333;
            --text-light: #777;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-dark);
            background-color: #fff;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 10px 25px;
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: #5a52d5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
            color: white;
        }

        /* Hero Section */
        .hero {
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        .hero h1 {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 30px;
        }
        .hero-img-container {
            position: relative;
            z-index: 1;
        }
        .hero-img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Features/Services */
        .features {
            padding: 80px 0;
            background-color: var(--secondary-color);
        }
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        .section-title h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .section-title p {
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }
        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: 1px solid #eee;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        }
        .icon-box {
            width: 70px;
            height: 70px;
            background: rgba(108, 99, 255, 0.1);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 20px;
        }

        /* Stats */
        .stats {
            padding: 60px 0;
            background-color: var(--primary-color);
            color: white;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
        }
        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* CTA Section */
        .cta {
            padding: 100px 0;
            text-align: center;
        }
        .cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* Footer */
        footer {
            background-color: #2D3436;
            color: white;
            padding: 50px 0 20px;
        }
        .footer-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
            transition: color 0.2s;
        }
        .footer-link:hover {
            color: white;
        }
        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: background 0.2s;
        }
        .social-link:hover {
            background: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero { padding: 60px 0; }
            .hero h1 { font-size: 2.5rem; }
            .hero-img { margin-top: 40px; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-paw me-2"></i>PetPal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-primary" href="{{ route('shop.index') }}" style="color: #0d6efd !important;">Shop</a>
                    </li>
                    
                    @guest
    <li class="nav-item ms-lg-3">
        <a href="{{ route('login') }}" class="nav-link">Log in</a>
    </li>

    <li class="nav-item ms-lg-2">
        <a href="{{ route('register') }}" class="btn btn-primary-custom">
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
            @if(auth()->user()->role === 'user')
            <li>
                <a class="dropdown-item" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i> My Cart
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('profile.orders') }}">
                    <i class="fas fa-box-open me-2 text-info"></i> My Orders
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            @endif
            <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Find Your New <br>Best Friend Today</h1>
                    <p>Connect with loving pets who need a home. We make pet adoption simple, secure, and joyful. Give a life a second chance.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('services.show', 'adoption') }}" class="btn btn-primary-custom btn-lg">Adopt a Pet</a>
                        <a href="#services" class="btn btn-outline-secondary btn-lg rounded-pill px-4">Our Services</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-img-container">
                        <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Happy Dog" class="hero-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="features">
        <div class="container">
            <div class="section-title">
                <h2>Our Premium Services</h2>
                <p>We provide comprehensive care and support for your furry friends.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-dog"></i>
                        </div>
                        <h3>PetPal</h3>
                        <p>Browse hundreds of adoptable pets. Filter by breed, age, and location to find your perfect match.</p>
                        <a href="{{ route('services.show', 'adoption') }}" class="btn btn-outline-primary rounded-pill mt-3 px-4">
    Read More
</a>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3>Pet Care Services</h3>
                        <p>Professional grooming, training, and veterinary services from verified providers in your area.</p>
                        <a href="{{ route('services.show', 'care') }}" class="btn btn-outline-primary rounded-pill mt-3 px-4">
    Read More
</a>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Community</h3>
                        <p>Join our vibrant community of pet lovers. Share stories, tips, and connect with others.</p>
                        <a href="{{ route('services.show', 'community') }}" class="btn btn-outline-primary rounded-pill mt-3 px-4">
    Read More
</a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="row text-center text-md-start align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="fw-bold mb-3">About The Pet Adoption System Project</h3>
                    <p class="mb-0 text-white-50" style="font-size: 1.1rem; line-height: 1.6;">
                        This platform was built to bridge the gap between loving homes and animals in need. By providing a secure, centralized hub for pet adoption and professional care services, we aim to streamline the process of finding forever homes while building a supportive community for pet parents everywhere.
                    </p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-inline-flex flex-column align-items-center align-items-lg-end">
                        <span class="fs-1 fw-bold mb-1"><i class="fas fa-heart text-danger"></i></span>
                        <span class="text-white-50 text-uppercase tracking-wider small fw-semibold">Built With Purpose</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="About Us" class="img-fluid rounded-4 shadow-lg">
                </div>
                <div class="col-lg-6 order-1 order-lg-2 ps-lg-5 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-4">Why Choose Us?</h2>
                    <p class="lead mb-4">We are more than just a platform; we are a movement to create a better world for animals.</p>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> Verified Profiles & Safe Adoption Process</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> Expert Care Advice & Resources</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> 24/7 Support for New Pet Parents</li>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="fw-bold mb-3"><i class="fas fa-paw me-2"></i>PetPal</h4>
                    <p class="text-white-50">Making the world a better place, one paw at a time. Join us in our mission to find every pet a loving home.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <a href="#" class="footer-link">Home</a>
                    <a href="#services" class="footer-link">Services</a>
                    <a href="#about" class="footer-link">About Us</a>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Connect With Us</h5>
                    <div class="d-flex mb-3">
                        <a href="https://www.facebook.com/aspca" target="_blank" rel="noopener noreferrer" class="social-link" title="Visit our Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/aspca/" target="_blank" rel="noopener noreferrer" class="social-link" title="Visit our Instagram"><i class="fab fa-instagram"></i></a>
                    </div>

                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center text-white-50">
                &copy; {{ date('Y') }} PetPal. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

