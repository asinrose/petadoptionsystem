@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Hero Section for Pet Home -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary mb-3">Find Your Perfect Companion</h1>
        <p class="lead text-muted">Browse through our available pets and give them a loving home.</p>
    </div>

    <!-- Search & Filters -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body p-4">
            <form action="{{ route('pethome') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by name or breed..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="dog" {{ request('type') == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ request('type') == 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="bird" {{ request('type') == 'bird' ? 'selected' : '' }}>Bird</option>
                        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="location" class="form-control" placeholder="Location" value="{{ request('location') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom w-100">Find Pet</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pets Grid -->
    <div class="row g-4">
        @if($pets->count() > 0)
            @foreach($pets as $pet)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 overflow-hidden">
                    <div class="position-relative">
                        <img src="{{ $pet->image ? $pet->image : 'https://placehold.co/600x400?text=No+Image' }}" class="card-img-top" alt="{{ $pet->name }}" style="height: 250px; object-fit: cover;">
                        <span class="position-absolute top-0 end-0 m-3 badge bg-white text-primary shadow-sm px-3 py-2 rounded-pill">
                            {{ ucfirst($pet->status) }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 class="h4 fw-bold mb-0">{{ $pet->name }}</h3>
                            <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> {{ $pet->location ?? 'Unknown' }}</span>
                        </div>
                        <p class="text-muted mb-3">{{ $pet->breed }} &bull; {{ $pet->age }} years &bull; {{ ucfirst($pet->gender) }}</p>
                        <p class="card-text text-muted mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit($pet->description, 80) }}</p>
                        
                        <div class="d-grid">
                            @if(auth()->id() === $pet->user_id)
                                <button class="btn btn-secondary disabled" disabled>Your Post</button>
                            @else
                                <form action="{{ route('adoption.store', $pet->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary-custom w-100">Adopt Me</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-paw text-muted" style="font-size: 4rem;"></i>
                </div>
                <h3 class="text-muted">No pets found matching your criteria.</h3>
                <a href="{{ route('pethome') }}" class="btn btn-outline-primary rounded-pill mt-3">Clear Filters</a>
            </div>
        @endif
    </div>
</div>
@endsection
