@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold display-5 text-primary">Create New Service</h1>
            <p class="text-muted lead">Offer something amazing and helpful to the pet community!</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="card-header bg-white border-bottom-0 py-4 px-5">
                    <h5 class="fw-bold mb-0"><i class="fas fa-briefcase text-primary me-2"></i> Service Details</h5>
                </div>
                <div class="card-body p-0 px-5 pb-5">
                    <form action="{{ route('service-provider.services.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label text-muted small text-uppercase fw-bold mb-2">Service Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Premium Dog Walking" required>
                            @error('name')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="price" class="form-label text-muted small text-uppercase fw-bold mb-2">Price ($) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-dollar-sign text-muted"></i></span>
                                    <input type="number" step="0.01" min="0" class="form-control bg-light border-0 rounded-end @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="25.00" required>
                                </div>
                                @error('price')
                                    <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="duration_minutes" class="form-label text-muted small text-uppercase fw-bold mb-2">Duration (Minutes) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-0"><i class="far fa-clock text-muted"></i></span>
                                    <input type="number" min="15" step="15" class="form-control bg-light border-0 rounded-end @error('duration_minutes') is-invalid @enderror" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" placeholder="60" required>
                                </div>
                                @error('duration_minutes')
                                    <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="description" class="form-label text-muted small text-uppercase fw-bold mb-2">Service Description</label>
                            <textarea class="form-control bg-light border-0 rounded-3 @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Describe the wonderful service you will provide...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted small mt-2">
                                Provide specific details about what this service includes to attract more pet parents.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded-4 mt-4">
                            <a href="{{ route('service-provider.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-sm bg-white">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 btn-lg shadow fw-bold">
                                Create Service <i class="fas fa-check-circle ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
