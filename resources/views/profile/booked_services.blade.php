@extends('layouts.app')

@push('styles')
<style>
    /* Profile specific styles */
    .profile-wrapper {
        min-height: calc(100vh - 200px);
        padding: 40px 0;
    }
    .profile-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .profile-layout {
        display: flex;
        min-height: 600px;
    }

    /* Sidebar Styles */
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
        color: #2b2b2b;
    }
    .profile-menu {
        display: flex;
        flex-direction: column;
    }
    .profile-menu a, .profile-menu button.logout {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-radius: 10px;
        color: #555;
        text-decoration: none;
        margin-bottom: 10px;
        font-weight: 500;
        width: 100%;
        text-align: left;
    }
    .profile-menu a i, .profile-menu button.logout i {
        width: 22px;
        margin-right: 12px;
        font-size: 1.1rem;
    }
    .profile-menu a:hover, .profile-menu a.active {
        background: #fff1ec;
        color: #ff6a3d;
        border-left: 4px solid #ff6a3d;
    }
    .profile-menu button.logout {
        color: #ff3b3b;
        margin-top: 40px;
    }
    .profile-menu button.logout:hover {
        background: #fff1ec;
    }

    /* Content Area Styles */
    .profile-content {
        flex: 1;
        padding: 40px;
        background: #fdfdfd;
    }
    .content-header {
        margin-bottom: 30px;
    }
    .content-header h4 {
        font-weight: 700;
        color: #2b2b2b;
        margin: 0;
    }

    /* Service Booking Card Styles */
    .booking-card {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        border: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
    .booking-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .booking-info h5 {
        color: #2b2b2b;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .booking-info p {
        color: #777;
        font-size: 0.95rem;
        margin-bottom: 2px;
    }
    .booking-status {
        text-align: right;
    }
    .booking-status .badge {
        font-size: 0.85rem;
        padding: 8px 15px;
        border-radius: 50px;
        margin-bottom: 8px;
    }
    .status-pending { background-color: #f1c40f; color: #fff; }
    .status-confirmed { background-color: #2ecc71; color: #fff; }
    .status-completed { background-color: #3498db; color: #fff; }
    .status-cancelled { background-color: #e74c3c; color: #fff; }
    
    .booking-amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: #6C63FF;
    }

    @media (max-width: 768px) {
        .profile-layout {
            flex-direction: column;
        }
        .profile-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #eee;
        }
        .booking-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .booking-status {
            text-align: left;
            margin-top: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="container profile-wrapper">
    <div class="profile-card">
        <div class="profile-layout">
            
            <!-- LEFT SIDEBAR -->
            <div class="profile-sidebar">
                <h5>User Profile</h5>
                
                <div class="profile-menu">
                    <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> User info</a>
                    <a href="{{ route('pets.my_pets') }}"><i class="fas fa-paw"></i> My Pets</a>
                    <a href="{{ route('profile.favorites') }}"><i class="fas fa-heart"></i> Favorites</a>
                    <a href="{{ route('pets.create') }}"><i class="fas fa-plus"></i> Add pet</a>
                    <a href="{{ route('profile.booked_services') }}" class="active"><i class="far fa-calendar-alt"></i> Booked Services</a>
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
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="content-header">
                    <h4>My Booked Services</h4>
                </div>

                <div class="bookings-list">
                    
                    @forelse ($bookings as $booking)
                        <div class="booking-card">
                            <div class="booking-info">
                                <h5>{{ $booking->service->name ?? 'Unknown Service' }}</h5>
                                <p><i class="fas fa-user-tie me-2"></i>Provider: {{ $booking->service->serviceProvider->user->name ?? 'Unknown Provider' }}</p>
                                <p><i class="far fa-calendar-alt me-2"></i>Date: {{ \Carbon\Carbon::parse($booking->date)->format('F j, Y') }}</p>
                                @if($booking->start_time && $booking->end_time)
                                    <p><i class="far fa-clock me-2"></i>Time: {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</p>
                                @endif
                                <p><i class="fas fa-map-marker-alt me-2"></i>Location: {{ $booking->address }}</p>
                            </div>
                            <div class="booking-status">
                                <span class="badge status-{{ $booking->status == 'booked' ? 'pending' : $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                <div class="booking-amount mt-2">
                                    ₹{{ number_format($booking->total_price, 2) }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted" style="font-size: 3rem;">
                                <i class="far fa-calendar-times"></i>
                            </div>
                            <h5>No Services Booked Yet</h5>
                            <p class="text-muted mb-4">You haven't booked any services yet. Explore our trusted providers!</p>
                            <a href="{{ route('services.index') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                                Browse Services
                            </a>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-4">
                <div class="mb-3">
                    <i class="fas fa-sign-out-alt text-danger" style="font-size: 3rem;"></i>
                </div>
                <h5 class="fw-bold mb-3">Ready to leave?</h5>
                <p class="text-muted mb-4">You are about to logout from your PetPal account.</p>
                <form method="POST" action="{{ route('logout') }}" class="d-flex justify-content-center gap-2">
                    @csrf
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
