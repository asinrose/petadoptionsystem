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
                <h5>User Profile</h5>

                <div class="profile-menu">
                    <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> User info</a>
                    <a href="{{ route('pets.my_pets') }}"><i class="fas fa-paw"></i> My Pets</a>
                    <a href="{{ route('profile.favorites') }}" class="active"><i class="fas fa-heart"></i> Favorites</a>
                    <a href="{{ route('pets.create') }}"><i class="fas fa-plus"></i> Add pet</a>
                    <a href="{{ route('profile.booked_services') }}"><i class="far fa-calendar-alt"></i> Booked Services</a>
                    <a href="{{ route('profile.booked_pets') }}"><i class="fas fa-bone"></i> Booked Pets</a>
                    <a href="{{ route('profile.applications') }}"><i class="fas fa-paw"></i> Adoption Applications</a>

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
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <h4 class="fw-bold mb-4">My Favorite Pets</h4>

                <div class="row g-4">
                    
                     @if($favorites->count() > 0)
                    @foreach ($favorites as $pet)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0 overflow-hidden">
                                <div class="position-relative">
                                    <img src="{{ $pet->image ? asset('images/'.$pet->image) : 'https://placehold.co/600x400?text=No+Image' }}" class="card-img-top" alt="{{ $pet->name }}" style="height: 200px; object-fit: cover;">
                                    
                                    <form action="{{ route('favorite.toggle', $pet->id) }}" method="POST" class="position-absolute top-0 start-0 m-2">
                                        @csrf
                                        <button type="submit" class="btn btn-light shadow-sm rounded-circle p-2 d-flex align-items-center justify-content-center border-0" style="width: 35px; height: 35px;" title="Remove from Favorites">
                                            <i class="fas fa-heart text-danger fs-6"></i>
                                        </button>
                                    </form>
                                    
                                    <span class="position-absolute top-0 end-0 m-2 badge bg-white text-primary shadow-sm px-3 py-2 rounded-pill">
                                        {{ ucfirst($pet->status) }}
                                    </span>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="fw-bold mb-1">{{ $pet->name }}</h5>
                                    <p class="text-muted small mb-2">{{ $pet->breed }} &bull; {{ $pet->age }} years</p>
                                    
                                    <div class="d-grid mt-3">
                                        <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-primary-custom w-100 btn-sm pr-custom-btn-theme" style="background-color: #6a5acd; border-color: #6a5acd; color: white; padding: 10px; border-radius: 8px;">View / Adopt</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="far fa-heart text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-muted">You haven't liked any pets yet.</h5>
                        <a href="{{ route('pethome') }}" class="btn btn-outline-primary mt-3">Find a Pet</a>
                    </div>
                @endif
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
