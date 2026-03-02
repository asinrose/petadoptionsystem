@extends('layouts.app')

@section('content')

<style>
    .profile-wrapper {
        background: #f9fafb;
        padding: 40px 0;
    }

    .profile-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .profile-layout {
        display: flex;
        min-height: 600px;
    }

    /* LEFT SIDEBAR */
    .profile-sidebar {
        width: 260px;
        border-right: 1px solid #eee;
        padding: 30px 20px;
        background: #fff;
        flex-shrink: 0;
    }

    .profile-sidebar h5 {
        font-weight: 700;
        margin-bottom: 30px;
    }

    .profile-menu a,
    .profile-menu button {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-radius: 10px;
        color: #555;
        text-decoration: none;
        margin-bottom: 10px;
        font-weight: 500;
        width: 100%;
    }

    .profile-menu i {
        width: 22px;
        margin-right: 12px;
    }

    .profile-menu a.active {
        background: #fff1ec;
        color: #ff6a3d;
        border-left: 4px solid #ff6a3d;
    }

    .profile-menu .logout {
        color: #ff3b3b;
        margin-top: 40px;
    }

    /* RIGHT CONTENT */
    .profile-content {
        padding: 40px;
        flex: 1;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
    }

    .save-btn {
        background: #ff6a3d;
        color: #fff;
        border-radius: 30px;
        padding: 12px 50px;
        border: none;
        font-weight: 600;
        box-shadow: 0 10px 25px rgba(255,106,61,0.35);
    }

    .save-btn:hover {
        background: #ff5722;
    }

    @media (max-width: 991px) {
        .profile-layout {
            flex-direction: column;
        }

        .profile-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #eee;
        }
    }
</style>

<div class="container profile-wrapper">
    <div class="profile-card">
        <div class="profile-layout">

            <!-- LEFT SIDEBAR -->
            <div class="profile-sidebar">
                <h5>Provider Profile</h5>

                <div class="profile-menu">
                    <a href="#" class="active">
                        <i class="fas fa-user-tie"></i> Profile Info
                    </a>
                    <a href="{{ route('service-provider.dashboard') }}">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a href="#"><i class="fas fa-tasks"></i> My Services</a>
                    <a href="{{ route('service-provider.products.index') }}"><i class="fas fa-box-open"></i> Products</a>
                    <a href="#"><i class="fas fa-calendar-check"></i> Bookings</a>
                    <a href="#"><i class="fas fa-cog"></i> Settings</a>

                    <!-- Logout trigger -->
                    <button type="button"
                            class="btn border-0 bg-transparent text-start logout"
                            data-bs-toggle="modal"
                            data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </button>
                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="profile-content">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- PROFILE HEADER -->
                <div class="d-flex align-items-center mb-5">
                    <img src="{{ $user->profile_photo
                        ? asset('storage/'.$user->profile_photo)
                        : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                         class="profile-avatar me-4">

                    <div>
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                        <span class="badge bg-primary rounded-pill">Service Provider</span>
                    </div>
                </div>

                <!-- UPDATE FORM -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact" class="form-control"
                                   value="{{ old('contact', $user->contact) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Profile photo(Shop's picture suggested)</label>
                            <input type="file" name="profile_photo" class="form-control">
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <button type="submit" class="save-btn">Save Changes</button>
                    </div>
                </form>

                <!-- DELETE ACCOUNT -->
                <div class="text-center mt-4">
                    <form method="POST" action="{{ route('profile.destroy') }}"
                          onsubmit="return confirm('Are you sure you want to delete your account?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-link text-danger">Delete Account</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- LOGOUT MODAL -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="text-muted mb-0">Are you sure you want to log out?</p>
            </div>

            <div class="modal-footer border-0 justify-content-center gap-2">
                <button class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Cancel</button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger rounded-pill px-4">Log out</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
