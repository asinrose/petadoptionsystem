@extends('layouts.app')

@section('content')
<style>
    /* Dashboard Specific Styles */
    :root {
        --primary-color: #6C63FF;
        --secondary-color: #FF6584;
        --text-dark: #2d3748;
        --text-muted: #718096;
        --card-bg: #ffffff;
        --bg-surface: #f8f9fa;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #8B85FF 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: -3rem; /* Overlap effect */
        border-radius: 0 0 2rem 2rem;
        position: relative;
        z-index: 0;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(108, 99, 255, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1rem;
        transition: transform 0.3s ease;
    }

    .glass-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .bg-icon-primary { background: rgba(108, 99, 255, 0.1); color: var(--primary-color); }
    .bg-icon-success { background: rgba(72, 187, 120, 0.1); color: #48bb78; }
    .bg-icon-warning { background: rgba(236, 201, 75, 0.1); color: #ecc94b; }
    .bg-icon-danger  { background: rgba(245, 101, 101, 0.1); color: #f56565; }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        background: white;
        border: 1px solid #e2e8f0;
        color: var(--text-dark);
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        margin-bottom: 0.75rem;
    }

    .action-btn:hover {
        border-color: var(--primary-color);
        background: #f0f4ff;
        color: var(--primary-color);
        transform: translateX(5px);
    }

    .recent-booking-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }

    .recent-booking-item:last-child {
        border-bottom: none;
    }

    .recent-booking-item:hover {
        background-color: #fcfcfc;
    }

    .avatar-circle {
        width: 45px;
        height: 45px;
        background-color: #cbd5e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        margin-right: 1rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending { background: #fffaf0; color: #d69e2e; }
    .status-confirmed { background: #f0fff4; color: #38a169; }
    .status-completed { background: #ebf8ff; color: #3182ce; }

    /* Floating Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .hero-img {
        animation: float 6s ease-in-out infinite;
    }
</style>

<!-- Hero Header -->
<div class="dashboard-header">
    <div class="container">
        <div class="row align-items-center pb-5">
            <div class="col-md-8">
                <h6 class="text-uppercase letter-spacing-2 opacity-75 mb-2">Service Provider Panel</h6>
                <h1 class="display-4 fw-bold mb-3">Welcome, {{ Auth::user()->name }} 👋</h1>
                <p class="lead opacity-90 mb-0">Manage your services, track bookings, and grow your pet care business.</p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <!-- Placeholder for a dashboard illustration if needed -->
                <i class="fas fa-chart-pie fa-4x opacity-50 hero-img"></i>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5" style="margin-top: -3rem; position: relative; z-index: 1;">
    
    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-bold small text-uppercase mb-1">Total Services</p>
                        <h2 class="fw-bold mb-0">{{ $totalServices }}</h2> <!-- Dynamic Data Here -->
                    </div>
                    <div class="stat-icon bg-icon-primary">
                        <i class="fas fa-paw"></i>
                    </div>
                </div>
                <div class="mt-auto pt-3">
                    <a href="{{ route('service-provider.services.create') }}" class="badge bg-light text-primary rounded-pill px-3 py-2 text-decoration-none d-inline-block">
                        <i class="fas fa-plus me-1"></i> Add New
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-bold small text-uppercase mb-1">Pending Requests</p>
                        <h2 class="fw-bold mb-0">{{ $pendingRequests }}</h2> <!-- Dynamic Data Here -->
                    </div>
                    <div class="stat-icon bg-icon-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="mt-auto pt-3">
                    <span class="text-warning small fw-bold">
                        <i class="fas fa-exclamation-circle me-1"></i> Action Required
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-bold small text-uppercase mb-1">Total Bookings</p>
                        <h2 class="fw-bold mb-0">{{ $totalBookings }}</h2> <!-- Dynamic Data Here -->
                    </div>
                    <div class="stat-icon bg-icon-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="mt-auto pt-3">
                    <span class="text-success small fw-bold">
                        <i class="fas fa-arrow-up me-1"></i> +12% this month
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content Column -->
        <div class="col-lg-8">
            <div class="glass-card p-0 h-100">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i> Recent Bookings</h5>
                    <a href="#" class="btn btn-sm btn-light rounded-pill px-3 text-primary fw-bold">View All</a>
                </div>
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="p-0">
                    
                    @forelse ($recentBookings as $booking)

                        @php
                            $initials = collect(explode(' ', $booking->user->name))->map(function($segment) {
                                return strtoupper(substr($segment, 0, 1));
                            })->take(2)->join('');
                            $colors = ['bg-primary', 'bg-info', 'bg-success', 'bg-warning', 'bg-danger'];
                            $colorClass = $colors[crc32($booking->user->name) % count($colors)];
                            
                            $statusClassMap = [
                                'booked' => 'status-pending',
                                'confirmed' => 'status-confirmed',
                                'completed' => 'status-completed'
                            ];
                            $badgeClass = $statusClassMap[$booking->status] ?? 'status-pending';
                            
                            $duration = \Carbon\Carbon::parse($booking->start_time)->diffInHours(\Carbon\Carbon::parse($booking->end_time));
                        @endphp
                    
                        <div class="recent-booking-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $booking->id }}">
                            <div class="avatar-circle {{ $colorClass }}">{{ $initials }}</div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">{{ $booking->user->name }}</h6>
                                <p class="text-muted small mb-0">{{ $booking->service->name }} • {{ $duration }} hours</p>
                            </div>
                            <div class="text-end">
                                <div class="status-badge {{ $badgeClass }} mb-1">{{ $booking->status === 'booked' ? 'Pending' : ucfirst($booking->status) }}</div>
                                <small class="text-muted d-block" style="font-size: 0.7rem;">{{ $booking->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mt-3">No bookings yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            
            <!-- Quick Actions -->
            <div class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-4">Quick Actions</h5>
                
                <a href="{{ route('service-provider.services.create') }}" class="action-btn">
                    <span><i class="fas fa-plus-circle me-2 text-primary"></i> Add New Service</span>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </a>

                <a href="{{ route('service-provider.products.index') }}" class="action-btn">
                    <span><i class="fas fa-box-open me-2 text-info"></i> Manage Products</span>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </a>

                <a href="{{ route('service-provider.product-orders.index') }}" class="action-btn">
                    <span><i class="fas fa-shopping-cart me-2 text-primary"></i> View Product Orders</span>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </a>

                <a href="{{ route('profile.edit') }}" class="action-btn">
                    <span><i class="fas fa-user-edit me-2 text-warning"></i> Edit Profile</span>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </a>

                <a href="{{ route('service-provider.schedule') }}" class="action-btn">
                    <span><i class="fas fa-calendar-week me-2 text-success"></i> View Schedule</span>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </a>
            </div>

            <!-- Pro Tip or Ad -->
            <div class="glass-card p-4 text-center bg-primary text-white" style="background: linear-gradient(135deg, #6C63FF 0%, #a29bfe 100%);">
                <i class="fas fa-rocket fa-3x mb-3 text-white-50"></i>
                <h5 class="fw-bold">Boost Your Reach!</h5>
                <p class="small opacity-75 mb-3">Complete your profile to appear in top search results.</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-light rounded-pill px-4 text-primary fw-bold">Update Profile</a>
            </div>

        </div>
    </div>
</div>

<!-- Modals rendered outside of all containers to prevent z-index/overflow clipping issues -->
@foreach($recentBookings as $booking)
    @php
        $initials = collect(explode(' ', $booking->user->name))->map(function($segment) {
            return strtoupper(substr($segment, 0, 1));
        })->take(2)->join('');
        $colors = ['bg-primary', 'bg-info', 'bg-success', 'bg-warning', 'bg-danger'];
        $colorClass = $colors[crc32($booking->user->name) % count($colors)];
        
        $statusClassMap = [
            'booked' => 'status-pending',
            'confirmed' => 'status-confirmed',
            'completed' => 'status-completed'
        ];
        $badgeClass = $statusClassMap[$booking->status] ?? 'status-pending';
    @endphp
    <!-- Booking Details Modal -->
    <div class="modal fade" id="bookingModal{{ $booking->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="avatar-circle {{ $colorClass }} me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">{{ $initials }}</div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $booking->user->name }}</h5>
                            <span class="status-badge {{ $badgeClass }}">{{ $booking->status === 'booked' ? 'Pending' : ucfirst($booking->status) }}</span>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Service</label>
                            <p class="fw-bold mb-0">{{ $booking->service->name }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block text-uppercase">Total Earned</small>
                            <p class="fw-bold text-primary mb-0">₹{{ number_format($booking->total_price, 2) }}</p>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Date</label>
                            <p class="mb-0"><i class="far fa-calendar-alt text-muted me-2"></i>{{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</p>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Time</label>
                            <p class="mb-0"><i class="far fa-clock text-muted me-2"></i>{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</p>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Contact Information</label>
                            <p class="mb-1"><i class="fas fa-phone text-muted me-2"></i>{{ $booking->phone }}</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt text-muted me-2"></i>{{ $booking->address }}</p>
                        </div>
                        
                        @if($booking->notes)
                        <div class="col-12 mt-3">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Additional Notes</label>
                            <div class="p-3 bg-light rounded-3 small">
                                {{ $booking->notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-top bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    @if($booking->status === 'booked')
                        <form action="{{ route('service-provider.bookings.confirm', $booking) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                <i class="fas fa-check-circle me-2"></i>Confirm Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
