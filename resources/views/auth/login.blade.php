<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'PetPal') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #6C63FF;
        }
        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            background-color: white;
        }
        .login-container {
            min-height: 100vh;
        }
        .left-panel {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 40px;
            position: relative;
        }
        .right-panel {
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        .form-control {
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #e1e1e1;
            background-color: #f9f9f9;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-color);
            background-color: white;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            font-weight: 600;
            margin-top: 20px;
            border: none;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #5a52d5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
            color: white;
        }
        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            z-index: 10;
        }
        .back-home-mobile {
            display: none;
            margin-bottom: 20px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        .panel-img {
            max-width: 80%;
            margin-bottom: 30px;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .login-header {
            margin-bottom: 30px;
        }
        .login-header h2 {
            font-weight: 700;
            color: #333;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }
            .back-home-mobile {
                display: inline-block;
            }
            .right-panel {
               align-items: flex-start;
               padding-top: 40px; 
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="row h-100 min-vh-100">
            <!-- Left Panel -->
            <div class="col-md-6 left-panel">
                <a href="{{ url('/') }}" class="back-home"><i class="fas fa-arrow-left me-2"></i>Back to Home</a>
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/login-3305943-2757111.png" alt="Login Graphic" class="panel-img">
                <h2>Welcome Back!</h2>
                <p>Login to manage your adoptions, services, and check on your furry friends.</p>
            </div>

            <!-- Right Panel -->
            <div class="col-md-6 right-panel">
                <div class="login-form">
                    <a href="{{ url('/') }}" class="back-home-mobile"><i class="fas fa-arrow-left me-2"></i>Back to Home</a>
                    <div class="login-header">
                        <h2>Sign In</h2>
                        <p class="text-muted">Enter your credentials to continue</p>
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small text-muted" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary-custom">
                            Login
                        </button>

                        <p class="text-center mt-4 text-muted">
                            Don't have an account? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Sign up</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
