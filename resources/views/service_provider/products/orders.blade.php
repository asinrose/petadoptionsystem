@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Product Orders</h2>
            <p class="text-muted mb-0">Track and manage orders for your listed products.</p>
        </div>
        <a href="{{ route('service-provider.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-muted small text-uppercase">Product</th>
                            <th class="px-4 py-3 text-muted small text-uppercase">Buyer Info</th>
                            <th class="px-4 py-3 text-muted small text-uppercase">Shipping Address</th>
                            <th class="px-4 py-3 text-center text-muted small text-uppercase">Quantity</th>
                            <th class="px-4 py-3 text-end text-muted small text-uppercase">Total Earned</th>
                            <th class="px-4 py-3 text-center text-muted small text-uppercase">Status</th>
                            <th class="px-4 py-3 text-muted small text-uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orderItems as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($item->product->image)
                                        <img src="{{ asset('images/' . $item->product->image) }}" class="rounded me-3 object-fit-cover" width="48" height="48" alt="{{ $item->product->name }}">
                                    @else
                                        <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center text-muted" style="width: 48px; height: 48px;">
                                            <i class="fas fa-box"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                        <small class="text-muted">₹{{ number_format($item->price, 2) }} each</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-bold">{{ $item->order->user->name ?? 'Unknown User' }}</div>
                                <small class="text-muted">{{ $item->order->user->email ?? 'N/A' }}</small>
                            </td>
                            <td class="px-4 py-3" style="max-width: 200px;">
                                <small class="d-block text-truncate" title="{{ $item->order->shipping_address }}">
                                    {{ $item->order->shipping_address }}
                                </small>
                            </td>
                            <td class="px-4 py-3 text-center fw-bold">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-4 py-3 text-end fw-bold text-success">
                                ₹{{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($item->order->status === 'pending')
                                    <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                @elseif($item->order->status === 'paid')
                                    <span class="badge bg-success rounded-pill">Paid</span>
                                @elseif($item->order->status === 'shipped')
                                    <span class="badge bg-info rounded-pill">Shipped</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">{{ ucfirst($item->order->status) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-muted">
                                <small>{{ $item->created_at->format('M d, Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted mb-3" style="font-size: 3rem;">
                                    <i class="fas fa-box-open opacity-50"></i>
                                </div>
                                <h5 class="text-muted">No products have been ordered yet.</h5>
                                <p class="text-muted small">When users buy your products, they will appear here.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orderItems->hasPages())
                <div class="px-4 py-3 border-top bg-light">
                    {{ $orderItems->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
