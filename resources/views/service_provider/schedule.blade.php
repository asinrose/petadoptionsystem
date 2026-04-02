@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-primary mb-1"><i class="fas fa-calendar-week me-2 text-success"></i> My Schedule</h2>
            <p class="text-muted mb-0">Manage your upcoming and pending service bookings.</p>
        </div>
        <a href="{{ route('service-provider.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 fw-bold py-4 border-0">Client</th>
                                    <th class="fw-bold py-4 border-0">Service</th>
                                    <th class="fw-bold py-4 border-0">Date & Time</th>
                                    <th class="fw-bold py-4 border-0">Location & Contact</th>
                                    <th class="text-center fw-bold py-4 border-0">Status</th>
                                    <th class="pe-4 fw-bold text-end py-4 border-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    @php
                                        $initials = collect(explode(' ', $booking->user->name))->map(function($segment) {
                                            return strtoupper(substr($segment, 0, 1));
                                        })->take(2)->join('');
                                        $colors = ['bg-primary', 'bg-info', 'bg-success', 'bg-warning', 'bg-danger'];
                                        $colorClass = $colors[crc32($booking->user->name) % count($colors)];
                                        
                                        $statusClassMap = [
                                            'booked' => 'bg-warning text-dark',
                                            'confirmed' => 'bg-success text-white',
                                            'completed' => 'bg-info text-white'
                                        ];
                                        $badgeClass = $statusClassMap[$booking->status] ?? 'bg-secondary text-white';
                                    @endphp
                                    <tr class="border-bottom {{ $loop->last ? 'border-0' : '' }}">
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3 {{ $colorClass }} fw-bold" style="width: 48px; height: 48px; font-size: 1.1rem;">
                                                    {{ $initials }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark">{{ $booking->user->name }}</h6>
                                                    <a href="mailto:{{ $booking->user->email }}" class="text-muted small text-decoration-none hover-primary">{{ $booking->user->email }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <span class="fw-bold text-dark d-block mb-1">{{ $booking->service->name }}</span>
                                            <span class="badge bg-light text-primary rounded-pill px-3 py-1 fw-semibold">₹{{ number_format($booking->total_price, 2) }}</span>
                                        </td>
                                        <td class="py-4">
                                            <div class="fw-bold text-dark mb-1"><i class="far fa-calendar-alt text-primary me-2 opacity-75"></i> {{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</div>
                                            <div class="text-muted small fw-medium"><i class="far fa-clock text-primary me-2 opacity-75"></i> {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</div>
                                        </td>
                                        <td class="py-4" style="max-width: 250px;">
                                            <div class="text-truncate text-dark fw-medium mb-1" title="{{ $booking->address }}"><i class="fas fa-map-marker-alt text-danger me-2 opacity-75"></i> {{ $booking->address }}</div>
                                            <a href="tel:{{ $booking->phone }}" class="text-muted small text-decoration-none hover-primary fw-medium"><i class="fas fa-phone-alt text-success me-2 opacity-75"></i> {{ $booking->phone }}</a>
                                        </td>
                                        <td class="text-center py-4">
                                            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 text-uppercase letter-spacing-1 fw-bold">
                                                {{ $booking->status === 'booked' ? 'Pending' : ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end py-4">
                                            @if($booking->status === 'booked')
                                                <form action="{{ route('service-provider.bookings.confirm', $booking) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 py-2 fw-bold shadow-sm" title="Confirm Booking">
                                                        <i class="fas fa-check-circle me-1"></i> Confirm
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-light rounded-pill px-4 py-2 text-muted fw-bold" disabled>
                                                    <i class="fas fa-check-double me-1 text-success"></i> Confirmed
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="mb-4 text-muted opacity-25">
                                                <i class="far fa-calendar-check" style="font-size: 5rem;"></i>
                                            </div>
                                            <h4 class="fw-bold text-dark mb-2">No Upcoming Bookings</h4>
                                            <p class="text-muted mb-0 lead">Your schedule is currently clear. Enjoy your free time!</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Optional: Card Footer for pagination if ever added -->
                @if($bookings->count() > 0)
                    <div class="card-footer bg-white border-top-0 p-4 text-center">
                        <span class="text-muted small fw-medium">Displaying {{ $bookings->count() }} active booking(s)</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
