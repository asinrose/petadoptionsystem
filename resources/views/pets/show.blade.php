@extends('layouts.app')

@section('content')

<style>
    .pet-details-wrapper {
        background: #f9fafb;
        padding: 40px 0;
    }

    .detail-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 25px;
    }

    .pet-image-container {
        height: 400px;
        width: 100%;
        position: relative;
    }

    .pet-hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 30px;
        background: #f4f6f9;
        font-weight: 500;
        margin-right: 10px;
        margin-bottom: 10px;
        color: #555;
    }

    .info-badge i {
        margin-right: 8px;
        color: #ff6a3d;
    }

    .section-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f4f6f9;
    }

    .detail-item {
        margin-bottom: 15px;
    }

    .detail-label {
        color: #777;
        font-size: 0.9rem;
        margin-bottom: 5px;
        display: block;
    }

    .detail-value {
        font-weight: 600;
        color: #333;
        font-size: 1.05rem;
    }

    .action-card {
        padding: 30px;
        text-align: center;
        background: linear-gradient(135deg, #fff1ec 0%, #fff 100%);
        border: 1px solid rgba(255, 106, 61, 0.2);
    }
</style>

<div class="pet-details-wrapper">
    <div class="container">
        <!-- Back Button -->
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('pethome') }}" class="btn btn-outline-secondary rounded-pill mb-4 px-4">
            <i class="fas fa-arrow-left me-2"></i> Back to Pets
        </a>

        @if(session('success'))
            <div class="alert alert-success rounded-3 mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info rounded-3 mb-4">
                {{ session('info') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger rounded-3 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Column: Image and Main Info -->
            <div class="col-lg-8">
                <div class="detail-card">
                    <div class="pet-image-container">
                        <img src="{{ $pet->image ? asset('storage/'.$pet->image) : 'https://placehold.co/800x600?text=No+Image' }}" class="pet-hero-img" alt="{{ $pet->name }}">
                        <span class="position-absolute top-0 end-0 m-4 badge bg-white text-primary shadow px-4 py-2 rounded-pill fs-6">
                            {{ ucfirst($pet->status) }}
                        </span>
                        
                        <!-- Favorite Button -->
                        @auth
                            @if(auth()->id() !== $pet->user_id)
                                <form action="{{ route('favorite.toggle', $pet->id) }}" method="POST" class="position-absolute top-0 start-0 m-4">
                                    @csrf
                                    <button type="submit" class="btn btn-light shadow rounded-circle p-2 d-flex align-items-center justify-content-center border-0" style="width: 50px; height: 50px;">
                                        @if(auth()->user()->favorites()->where('pet_id', $pet->id)->exists())
                                            <i class="fas fa-heart text-danger fs-4"></i>
                                        @else
                                            <i class="far fa-heart text-muted fs-4"></i>
                                        @endif
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    
                    <div class="p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="fw-bold mb-0 display-5">{{ $pet->name }}</h1>
                        </div>
                        
                        <div class="mb-4">
                            <span class="info-badge"><i class="fas fa-paw"></i> {{ ucfirst($pet->type) }}</span>
                            <span class="info-badge"><i class="fas fa-dna"></i> {{ $pet->breed }}</span>
                            <span class="info-badge"><i class="fas fa-birthday-cake"></i> {{ $pet->age }} years</span>
                            <span class="info-badge"><i class="fas fa-venus-mars"></i> {{ ucfirst($pet->gender) }}</span>
                            <span class="info-badge"><i class="fas fa-map-marker-alt"></i> {{ $pet->location }}</span>
                        </div>

                        <h4 class="section-title mt-5">About {{ $pet->name }}</h4>
                        <p class="text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                            {{ $pet->description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details and Action -->
            <div class="col-lg-4">
                
                <!-- Action Card -->
                <div class="detail-card action-card">
                    <h3 class="fw-bold mb-3">Interested in {{ $pet->name }}?</h3>
                    <p class="text-muted mb-4">Adopting a pet is a beautiful journey. Submit your request today!</p>
                    
                    @if($pet->adoption_type == 'free')
                        <div class="alert alert-success fs-5 fw-bold py-3 rounded-3 mb-4">
                            <i class="fas fa-gift me-2"></i> Free Adoption
                        </div>
                    @else
                        <div class="alert alert-warning fs-5 fw-bold py-3 rounded-3 mb-4 text-dark">
                            <i class="fas fa-tag me-2"></i> Adoption Fee: ${{ number_format($pet->adoption_fee, 2) }}
                        </div>
                    @endif

                    @auth
                        @if(auth()->id() === $pet->user_id)
                            <button class="btn btn-secondary w-100 py-3 rounded-pill fw-bold fs-5 disabled">You posted this pet</button>
                        @elseif($pet->status !== 'available')
                            <button class="btn btn-secondary w-100 py-3 rounded-pill fw-bold fs-5 disabled">Not available for adoption</button>
                        @else
                            <form action="{{ route('adoption.store', $pet->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold fs-5 shadow">Send Adoption Request</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold fs-5 shadow">Log in to Adopt</a>
                    @endauth
                </div>

                <!-- Pet Details Card -->
                <div class="detail-card p-4">
                    <h5 class="section-title mt-0">Health & Details</h5>
                    
                    <div class="row">
                        <div class="col-6 detail-item">
                            <span class="detail-label"><i class="fas fa-weight-hanging me-1 text-muted"></i> Weight</span>
                            <span class="detail-value">{{ $pet->weight ?: 'Not specified' }}</span>
                        </div>
                        <div class="col-6 detail-item">
                            <span class="detail-label"><i class="fas fa-bug me-1 text-muted"></i> Dewormed</span>
                            <span class="detail-value">
                                @if($pet->dewormed)
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Yes</span>
                                @else
                                    <span class="text-danger"><i class="fas fa-times-circle"></i> No</span>
                                @endif
                            </span>
                        </div>
                        <div class="col-12 detail-item mt-2">
                            <span class="detail-label"><i class="fas fa-syringe me-1 text-muted"></i> Vaccination Status</span>
                            <span class="detail-value">
                                @if($pet->vaccination_status == 'vaccinated')
                                    <span class="badge bg-success">Vaccinated</span> 
                                    @if($pet->vaccination_date)
                                      <span class="text-muted ms-2 fs-6 fw-normal">(Date: {{ \Carbon\Carbon::parse($pet->vaccination_date)->format('M d, Y') }})</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Not Vaccinated</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    @if($pet->medical_conditions)
                        <div class="detail-item mt-3 p-3 bg-light rounded-3 border-start border-warning border-4">
                            <span class="detail-label text-warning"><i class="fas fa-notes-medical me-1"></i> Medical Conditions</span>
                            <span class="detail-value text-dark fs-6 fw-normal">{{ $pet->medical_conditions }}</span>
                        </div>
                    @endif

                    @if($pet->special_care_requirements)
                        <div class="detail-item mt-3 p-3 bg-light rounded-3 border-start border-info border-4">
                            <span class="detail-label text-info"><i class="fas fa-heartbeat me-1"></i> Special Care Needed</span>
                            <span class="detail-value text-dark fs-6 fw-normal">{{ $pet->special_care_requirements }}</span>
                        </div>
                    @endif
                </div>
                
                <!-- Contact Card -->
                <div class="detail-card p-4">
                    <h5 class="section-title mt-0">Contact Poster</h5>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 overflow-hidden shadow-sm" style="width: 50px; height: 50px;">
                            @if($pet->user->profile_photo)
                                <img src="{{ asset('storage/' . $pet->user->profile_photo) }}" alt="{{ $pet->user->name }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <i class="fas fa-user fs-4"></i>
                            @endif
                        </div>
                        <div>
                            <span class="detail-label mb-0">Posted By</span>
                            <span class="detail-value">{{ $pet->user->name }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Email Address</div>
                        <div class="fw-bold fs-6">
                            <i class="fas fa-envelope text-primary me-2"></i> 
                            <a href="mailto:{{ $pet->user->email }}" class="text-dark text-decoration-none hover-primary">{{ $pet->user->email }}</a>
                        </div>
                    </div>

                    @if($pet->user->contact)
                        <div class="p-3 bg-light rounded-3">
                            <div class="text-muted small mb-1">Phone Number</div>
                            <div class="fw-bold fs-5"><i class="fas fa-phone-alt text-primary me-2"></i> {{ $pet->user->contact }}</div>
                        </div>
                    @else
                        <div class="p-3 bg-light rounded-3">
                             <div class="text-muted small mb-1">Phone Number</div>
                             <div class="text-muted fst-italic"><i class="fas fa-phone-slash me-2"></i> Not provided on profile</div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
