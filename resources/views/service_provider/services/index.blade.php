@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">My Services</h2>
            <p class="text-muted">Manage the services you offer to pet owners.</p>
        </div>
        <a href="{{ route('service-provider.services.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus me-2"></i> Add Service
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @if($services->count() > 0)
            @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm glass-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-bold text-dark">{{ $service->name }}</h5>
                                <span class="badge bg-light text-primary rounded-pill px-3">
                                    ₹{{ number_format($service->price, 2) }}
                                </span>
                            </div>
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($service->description, 100) }}
                            </p>
                            
                            <div class="d-flex align-items-center text-muted small mb-3">
                                <i class="fas fa-clock me-2"></i> {{ $service->duration_minutes }} mins
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status_{{ $service->id }}" {{ $service->is_active ? 'checked' : '' }} disabled>
                                    <label class="form-check-label small" for="status_{{ $service->id }}">
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary rounded-pill">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-paw fa-3x text-muted opacity-25"></i>
                </div>
                <h5 class="text-muted">No services added yet.</h5>
                <p class="text-muted small">Start by adding your first service to attract cutomers.</p>
            </div>
        @endif
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title fw-bold" id="addServiceModalLabel">Add New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('service-provider.services.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small text-uppercase">Service Name</label>
                        <input type="text" class="form-control bg-light border-0" id="name" name="name" placeholder="e.g. Dog Walking" required>
                    </div>
                    
                    <div class="row g-3 mb-3">
                         <div class="col-6">
                            <label for="price" class="form-label fw-bold small text-uppercase">Price ($)</label>
                            <input type="number" step="0.01" class="form-control bg-light border-0" id="price" name="price" placeholder="0.00" required>
                        </div>
                        <div class="col-6">
                             <label for="duration" class="form-label fw-bold small text-uppercase">Duration (min)</label>
                             <input type="number" class="form-control bg-light border-0" id="duration" name="duration_minutes" placeholder="60" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold small text-uppercase">Description</label>
                        <textarea class="form-control bg-light border-0" id="description" name="description" rows="3" placeholder="Describe what's included..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Create Service</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection