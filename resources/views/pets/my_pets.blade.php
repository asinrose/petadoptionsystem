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

    .pet-card {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .pet-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: #ff6a3d;
    }

    .pet-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
    }

    .pet-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
        margin-top: 15px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
    }

    .detail-item {
        font-size: 0.9rem;
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-weight: 600;
        color: #777;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .detail-value {
        color: #333;
        font-weight: 500;
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
                    <a href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i> User info
                    </a>
                    <a href="{{ route('pets.my_pets') }}" class="active"><i class="fas fa-paw"></i> My Pets</a>
                    <a href="{{ route('profile.favorites') }}"><i class="far fa-heart"></i> Favorites</a>
                    <a href="{{ route('pets.create') }}"><i class="far fa-plus"></i> Add pet</a>
                    <a href="#"><i class="far fa-calendar-alt"></i> Booked Services</a>
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">My Posted Pets</h4>
                    <a href="{{ route('pets.create') }}" class="btn btn-sm save-btn rounded-pill px-4 py-2" style="background: #ff6a3d; color: white;">
                        <i class="fas fa-plus me-1"></i> Post New Pet
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($pets->count() > 0)
                    @foreach ($pets as $pet)
                    <div class="pet-card">
                        <div class="d-flex flex-column flex-md-row gap-4">
                            <img src="{{ asset('storage/' . $pet->image) }}" class="pet-image" alt="{{ $pet->name }}">
                            
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1 fw-bold">{{ $pet->name }} 
                                            <span class="badge bg-{{ $pet->status == 'available' ? 'success' : 'secondary' }} ms-2" style="font-size: 0.6em; vertical-align: middle;">
                                                {{ ucfirst($pet->status) }}
                                            </span>
                                        </h5>
                                        <p class="text-muted mb-2 small">{{ $pet->breed }} &bull; {{ $pet->age }} years &bull; {{ ucfirst($pet->gender) }}</p>
                                    </div>
                                    
                                    <form action="{{ route('pets.destroy', $pet) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this pet? It will be deleted permanently.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                        </button>
                                    </form>
                                </div>

                                <div class="pet-details-grid">
                                    <div class="detail-item">
                                        <span class="detail-label">Type</span>
                                        <span class="detail-value">{{ ucfirst($pet->type) }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Location</span>
                                        <span class="detail-value">{{ $pet->location }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Contact</span>
                                        <span class="detail-value">{{ $pet->contact }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Weight</span>
                                        <span class="detail-value">{{ $pet->weight ?? 'N/A' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Vaccinated</span>
                                        <span class="detail-value">
                                            {{ $pet->vaccination_status == 'vaccinated' ? 'Yes' : 'No' }}
                                            @if($pet->vaccination_date) <span class="text-muted small">({{ \Carbon\Carbon::parse($pet->vaccination_date)->format('M d, Y') }})</span> @endif
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Dewormed</span>
                                        <span class="detail-value">{{ $pet->dewormed ? 'Yes' : 'No' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Adoption</span>
                                        <span class="detail-value">
                                            {{ ucfirst($pet->adoption_type) }} 
                                            @if($pet->adoption_type == 'fee') <span class="text-success fw-bold">${{ $pet->adoption_fee }}</span> @endif
                                        </span>
                                    </div>
                                </div>
                                
                                @if($pet->medical_conditions)
                                <div class="mt-3">
                                    <span class="detail-label">Medical Conditions</span>
                                    <p class="mb-0 small text-muted bg-light p-2 rounded">{{ $pet->medical_conditions }}</p>
                                </div>
                                @endif
                                
                                @if($pet->special_care_requirements)
                                <div class="mt-2">
                                    <span class="detail-label">Special Care Requirements</span>
                                    <p class="mb-0 small text-muted bg-light p-2 rounded">{{ $pet->special_care_requirements }}</p>
                                </div>
                                @endif
                                
                                <div class="mt-3">
                                    <span class="detail-label">Description</span>
                                    <p class="mb-0 small text-muted">{{ $pet->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-paw fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted">You haven't posted any pets yet.</h5>
                        <p class="text-muted small">Share your pets with the community for adoption.</p>
                        <a href="{{ route('pets.create') }}" class="btn save-btn rounded-pill mt-2 px-4" style="background: #ff6a3d; color: white;">Post a Pet</a>
                    </div>
                @endif

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
