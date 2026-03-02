@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="fw-bold text-primary">Checkout</h2>
        <a href="{{ route('cart.index') }}" class="text-decoration-none text-muted fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Back to Cart
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold mb-4">Shipping Details</h4>
                    <form action="{{ route('order.store') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label fw-bold small text-uppercase">First Name</label>
                                <input type="text" class="form-control bg-light border-0" id="first_name" required value="{{ auth()->user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label fw-bold small text-uppercase">Last Name</label>
                                <input type="text" class="form-control bg-light border-0" id="last_name" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="phone" class="form-label fw-bold small text-uppercase">Phone</label>
                                <input type="tel" class="form-control bg-light border-0" id="phone" required value="{{ auth()->user()->contact }}">
                            </div>

                            <div class="col-12">
                                <label for="shipping_address" class="form-label fw-bold small text-uppercase">Full Address</label>
                                <textarea class="form-control bg-light border-0" id="shipping_address" name="shipping_address" rows="3" required placeholder="Street address, City, State, Zip Code"></textarea>
                            </div>
                        </div>

                        <h4 class="fw-bold mt-5 mb-4">Payment Method</h4>
                        <div class="mb-4">
                            <div class="form-check custom-radio border rounded-3 p-3 mb-3 bg-light">
                                <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="payment_cod" value="cash_on_delivery" checked>
                                <label class="form-check-label w-100 d-flex justify-content-between align-items-center fw-bold" for="payment_cod">
                                    <span>Cash on Delivery</span>
                                    <i class="fas fa-money-bill-wave text-success fa-lg"></i>
                                </label>
                            </div>

                            <div class="form-check custom-radio border rounded-3 p-3 opacity-50 bg-light position-relative">
                                <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="payment_card" value="card" disabled>
                                <label class="form-check-label w-100 d-flex justify-content-between align-items-center fw-bold text-muted" for="payment_card">
                                    <span>Credit / Debit Card</span>
                                    <div class="d-flex gap-2 text-muted">
                                        <i class="fab fa-cc-visa fa-lg"></i>
                                        <i class="fab fa-cc-mastercard fa-lg"></i>
                                    </div>
                                </label>
                                <span class="badge bg-secondary position-absolute top-0 end-0 translate-middle-y me-3">Coming Soon</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 100px;">
                <div class="card-body p-4 pb-5">
                    <h5 class="fw-bold mb-4">Order Summary</h5>
                    
                    <div class="mb-4">
                        @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center overflow-hidden">
                                     <span class="badge bg-secondary rounded-pill me-2">{{ $item->quantity }}</span>
                                     <span class="text-truncate" style="max-width: 150px;">{{ $item->product->name }}</span>
                                </div>
                                <span class="fw-bold">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <hr class="text-muted opacity-25 mb-4">
                    
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Subtotal</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Shipping</span>
                        <span class="text-success fw-bold">Free</span>
                    </div>
                    
                    <hr class="my-4 border-2">
                    
                    <div class="d-flex justify-content-between mb-5">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-4 fw-bold text-primary">${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <button type="submit" form="checkout-form" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow">
                        Place Order <i class="fas fa-check-circle ms-2"></i>
                    </button>
                    
                    <div class="text-center mt-3 text-muted small">
                        <i class="fas fa-lock me-1"></i> Secure Checkout
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
