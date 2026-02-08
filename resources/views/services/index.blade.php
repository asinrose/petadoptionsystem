@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Find Services</h5>
                    <form action="{{ route('services.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Service Type</label>
                            <select name="service_type" class="form-select rounded-pill">
                                <option value="">All Services</option>
                                @foreach($serviceTypes as $type)
                                    <option value="{{ $type }}" @selected(request('service_type') == $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Date</label>
                            <input type="date" name="date" class="form-control rounded-pill" value="{{ request('date') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Time</label>
                            <select name="time" class="form-select rounded-pill" required>
                                <option value="">Select Time</option>
                                @foreach(['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $t)
                                    <option value="{{ $t }}" @selected(request('time') == $t)>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                            <i class="fas fa-search me-2"></i> Check Availability
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Service List -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Available Services</h3>
                <span class="text-muted">{{ $services->total() }} results found</span>
            </div>

            @if(session('success'))
                <div class="alert alert-success rounded-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger rounded-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row g-4">
                @if($services->count() > 0)
                    @foreach($services as $service)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $service->provider->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.$service->provider->user->name }}" 
                                             class="rounded-circle me-3" width="50" height="50" alt="Provider">
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $service->provider->user->name }}</h6>
                                            <small class="text-muted">Pro Service Provider</small>
                                        </div>
                                    </div>
                                    
                                    <h5 class="fw-bold text-primary">{{ $service->name }}</h5>
                                    <p class="text-muted small mb-3">{{ Str::limit($service->description, 80) }}</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="fw-bold h5 mb-0">${{ $service->price }}</span>
                                        <span class="badge bg-light text-dark rounded-pill">
                                            <i class="fas fa-clock me-1"></i> {{ $service->duration_minutes }}m
                                        </span>
                                    </div>

                                    <button type="button" 
                                            class="btn btn-outline-primary w-100 rounded-pill"
                                            @disabled(!(request('date') && request('time')))
                                            data-bs-toggle="modal" 
                                            data-bs-target="#bookModal{{ $service->id }}">
                                        {{ (request('date') && request('time')) ? 'Book Now' : 'Select Date & Time' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Modal -->
                        <div class="modal fade" id="bookModal{{ $service->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0">
                                    <form action="{{ route('services.book') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                                        <input type="hidden" name="date" value="{{ request('date') }}">
                                        <input type="hidden" name="time" value="{{ request('time') }}">
                                        
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Confirm Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>You are booking <strong>{{ $service->name }}</strong> with <strong>{{ $service->provider->user->name }}</strong>.</p>
                                            <div class="d-flex justify-content-between bg-light p-3 rounded-3 mb-3">
                                                <div>
                                                    <small class="text-muted d-block uppercase">Date</small>
                                                    <strong>{{ request('date') }}</strong>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block uppercase">Time</small>
                                                    <strong>{{ request('time') }}</strong>
                                                </div>
                                                <div class="text-end">
                                                    <small class="text-muted d-block uppercase">Price</small>
                                                    <strong class="text-primary">${{ $service->price }}</strong>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Select Pet</label>
                                                <select name="pet_id" class="form-select rounded-pill" required>
                                                    <option value="">Choose a pet...</option>
                                                    @foreach($pets as $pet)
                                                        <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                                                    @endforeach
                                                    <!-- Fallback if user has no pets relation defined yet, need to check User model -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">Confirm Booking</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <div class="py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3 opacity-25"></i>
                            <h5 class="text-muted">No services found available at this time.</h5>
                            <p class="text-muted small">Try selecting a different date or time.</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-5">
                {{ $services->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
