@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Shopping Cart</h2>
        <a href="{{ route('shop.index') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
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
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-0">
                    
                    @forelse ($cartItems as $item)

                        <div class="d-flex align-items-center p-4 border-bottom {{ $loop->last ? 'border-0' : '' }}">
                            <!-- Product Image -->
                            <div class="flex-shrink-0 me-4">
                                @if($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}" class="rounded-3 object-fit-cover" alt="{{ $item->product->name }}" style="width: 100px; height: 100px;">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                        <i class="fas fa-box fa-2x text-muted opacity-50"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="fw-bold mb-0">
                                        <a href="{{ route('shop.show', $item->product) }}" class="text-dark text-decoration-none hover-primary">{{ $item->product->name }}</a>
                                    </h5>
                                    <span class="fs-5 fw-bold text-primary">₹{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                </div>
                                
                                <p class="text-muted small mb-3">Unit Price: ₹{{ number_format($item->product->price, 2) }}</p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm rounded-pill" style="width: 120px;">
                                            <input type="number" name="quantity" class="form-control text-center bg-light border-0 fw-bold" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" onchange="this.form.submit()">
                                        </div>
                                    </form>

                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-decoration-none p-0">
                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-muted opacity-25 mb-3"></i>
                            <h4 class="text-muted">Your cart is empty</h4>
                            <p class="text-muted small mb-4">Looks like you haven't added any products yet.</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">Start Shopping</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if($cartItems->isNotEmpty())
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 100px;">
                    <div class="card-body p-4 text-center pb-5">
                        <i class="fas fa-receipt fa-3x text-primary mb-3 opacity-75"></i>
                        <h4 class="fw-bold mb-4">Order Summary</h4>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                            <span class="fw-bold">₹{{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success fw-bold">Free</span>
                        </div>
                        
                        <hr class="my-4 border-2">
                        
                        <div class="d-flex justify-content-between mb-5">
                            <span class="fs-5 fw-bold">Total</span>
                            <span class="fs-4 fw-bold text-primary">₹{{ number_format($total, 2) }}</span>
                        </div>
                        
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow">
                            Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
