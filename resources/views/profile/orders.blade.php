@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold display-5 text-primary">My Orders</h1>
            <p class="text-muted lead">View and track your previous purchases</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @forelse($orders as $order)
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-light border-bottom-0 py-3 px-4 d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2 mb-md-0">
                            <span class="text-muted small text-uppercase fw-bold me-2">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> {{ $order->created_at->format('M d, Y - h:i A') }}</span>
                        </div>
                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-info text-white',
                                    'completed' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white',
                                ];
                                $statusClass = $statusColors[$order->status] ?? 'bg-secondary text-white';
                            @endphp
                            <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 text-uppercase letter-spacing-1">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover mb-0 align-middle">
                                <thead class="table-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4 fw-bold">Product</th>
                                        <th class="fw-bold text-center">Price</th>
                                        <th class="fw-bold text-center">Qty</th>
                                        <th class="pe-4 fw-bold text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}" class="rounded bg-light object-fit-cover me-3" style="width: 50px; height: 50px;" alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-box text-muted opacity-50"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('shop.show', $item->product) }}" class="text-dark fw-bold text-decoration-none hover-primary">{{ $item->product->name }}</a>
                                                        <div class="small text-muted">By {{ $item->product->serviceProvider->user->name ?? 'Unknown' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center py-3">${{ number_format($item->price, 2) }}</td>
                                            <td class="text-center py-3">{{ $item->quantity }}</td>
                                            <td class="pe-4 text-end fw-bold text-primary py-3">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-top py-3 px-4">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <div class="small">
                                    <span class="text-muted fw-bold text-uppercase d-block mb-1">Shipping Details</span>
                                    {{ $order->shipping_address }} <br>
                                    <span class="text-muted">Payment: {{ preg_replace('/[^A-Za-z0-9]/', ' ', ucfirst($order->payment_method)) }}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <span class="text-muted small text-uppercase fw-bold me-2">Order Total</span>
                                <span class="fs-4 fw-bold text-primary">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                    <i class="fas fa-box-open fa-4x text-muted opacity-25 mb-4 d-block"></i>
                    <h3 class="fw-bold text-muted mb-3">No orders found</h3>
                    <p class="text-muted lead mb-4">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill px-4 btn-lg shadow-sm">
                        Start Shopping <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
