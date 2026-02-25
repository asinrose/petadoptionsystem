<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auth - {{ config('app.name', 'PetPal') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('petpal-paw.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary-color: #6C63FF;
            --accent-color: #FF6584;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: #f6f5f7;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        h1 {
            font-weight: 700;
            margin: 0;
            color: #333;
        }

        p {
            font-size: 14px;
            font-weight: 300;
            line-height: 20px;
            letter-spacing: 0.5px;
            margin: 20px 0 30px;
        }

        span {
            font-size: 12px;
            color: #777;
        }

        a {
            color: #333;
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
        }
        
        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #333;
            text-decoration: none;
            font-weight: 600;
            z-index: 1000;
            background: white;
            padding: 8px 15px;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .back-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0,0,0,0.15);
        }

        .btn-custom {
            border-radius: 20px;
            border: 1px solid var(--primary-color);
            background-color: var(--primary-color);
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
            cursor: pointer;
        }

        .btn-custom:active {
            transform: scale(0.95);
        }

        .btn-custom:focus {
            outline: none;
        }

        .btn-custom.ghost {
            background-color: transparent;
            border-color: #FFFFFF;
        }

        form {
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        input {
            background-color: #eee;
            border: none;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
            border-radius: 8px;
        }

        .container-custom {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            position: relative;
            overflow: hidden;
            width: 900px;
            max-width: 100%;
            min-height: 600px;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container-custom.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container-custom.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container-custom.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: var(--primary-color);
            background: -webkit-linear-gradient(to right, #FF6584, #6C63FF);
            background: linear-gradient(to right, #FF6584, #6C63FF);
            background-repeat: no-repeat;
            background-size: 200% 100%;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container-custom.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .container-custom.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .container-custom.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        .is-invalid {
            border: 1px solid #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0rem;
            margin-bottom: .25rem;
            font-size: .875em;
            color: #dc3545;
            text-align: left;
        }

        .mobile-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .container-custom {
                min-height: 100vh;
                width: 100%;
                border-radius: 0;
            }
            .form-container {
                width: 100%;
                height: 100%;
                opacity: 1 !important;
                visibility: visible !important;
                transform: none !important;
                transition: none !important;
            }
            .sign-in-container {
                z-index: 2;
                display: block;
            }
            .sign-up-container {
                z-index: 1;
                display: none;
            }
            .container-custom.right-panel-active .sign-in-container {
                display: none;
            }
            .container-custom.right-panel-active .sign-up-container {
                display: flex;
                z-index: 2;
            }
            .overlay-container {
                display: none;
            }
            .mobile-toggle {
                display: block !important;
                margin-top: 20px;
            }
            form {
                padding: 40px 20px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <a href="{{ url('/') }}" class="back-home"><i class="fas fa-arrow-left me-2"></i>Home</a>

    <div class="container-custom @if(request()->routeIs('register') || $errors->has('name') || old('is_service_provider')) right-panel-active @endif" id="container">
        
        <!-- Sign Up Panel -->
        <div class="form-container sign-up-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1 class="mb-3 mt-4">Create Account</h1>
                <span>Use your email for registration</span>
                
                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Full Name">
                @error('name')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror

                <input id="register-email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                @if($errors->has('email') && request()->routeIs('register'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                @endif

                <input id="register-password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                @if($errors->has('password') && request()->routeIs('register'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                @endif

                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">

                <div class="form-check text-start w-100 mt-2 mb-3 ms-2">
                    <input type="checkbox" class="form-check-input" id="is_service_provider" name="is_service_provider" value="1" {{ old('is_service_provider') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="is_service_provider" style="font-size: 14px;">
                        Join as a <strong>Service Provider</strong>
                    </label>
                </div>

                <button type="submit" class="btn-custom mt-2">Sign Up</button>
                
                <div class="mobile-toggle text-center w-100">
                    <p class="mb-0 mt-3">Already have an account? <a href="#" id="signInMobile" class="text-primary fw-bold" style="font-size: 14px; margin:0;">Sign In</a></p>
                </div>
            </form>
        </div>

        <!-- Sign In Panel -->
        <div class="form-container sign-in-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="mb-3">Sign in</h1>
                <span>Use your account</span>
                
                <input id="login-email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                @if($errors->has('email') && request()->routeIs('login'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                @endif

                <input id="login-password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                @if($errors->has('password') && request()->routeIs('login'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                @endif

                <div class="d-flex justify-content-between align-items-center w-100 mt-2 mb-3">
                    <div class="form-check text-start ms-2">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember" style="font-size: 14px;">Remember me</label>
                    </div>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="mb-4">Forgot your password?</a>
                @endif
                
                <button type="submit" class="btn-custom">Sign In</button>
                
                <div class="mobile-toggle text-center w-100">
                    <p class="mb-0 mt-3">Don't have an account? <a href="#" id="signUpMobile" class="text-primary fw-bold" style="font-size: 14px; margin:0;">Sign Up</a></p>
                </div>
            </form>
        </div>

        <!-- Sliding Overlay -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Pet Login" class="mb-3 shadow-sm" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 4px solid rgba(255,255,255,0.4);">
                    <h1 class="text-white">Welcome Back!</h1>
                    <p class="text-white">To keep connected with us please login with your personal info</p>
                    <button class="btn-custom ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Pet Adoption" class="mb-3 shadow-sm" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 4px solid rgba(255,255,255,0.4);">
                    <h1 class="text-white">Join Our Community!</h1>
                    <p class="text-white">Create an account to adopt pets, offer services, and be part of the family.</p>
                    <button class="btn-custom ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const signUpMobile = document.getElementById('signUpMobile');
        const signInMobile = document.getElementById('signInMobile');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', (e) => {
            e.preventDefault();
            container.classList.add("right-panel-active");
            // Optionally update URL without reload to preserve state semantics
            window.history.pushState({}, '', '/register');
        });

        signInButton.addEventListener('click', (e) => {
            e.preventDefault();
            container.classList.remove("right-panel-active");
            window.history.pushState({}, '', '/login');
        });
        
        signUpMobile.addEventListener('click', (e) => {
            e.preventDefault();
            container.classList.add("right-panel-active");
            window.history.pushState({}, '', '/register');
        });

        signInMobile.addEventListener('click', (e) => {
            e.preventDefault();
            container.classList.remove("right-panel-active");
            window.history.pushState({}, '', '/login');
        });

        // Ensure proper error state handling via JavaScript if blade fails
        if(document.querySelector('.sign-up-container .is-invalid') && !container.classList.contains("right-panel-active")) {
            container.classList.add("right-panel-active");
        }
    </script>
</body>
</html>
