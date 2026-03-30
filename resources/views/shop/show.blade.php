@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('shop.index') }}" class="text-decoration-none text-muted fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Back to Shop
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 rounded-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                @if($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 400px;">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 bg-light" style="min-height: 400px;">
                        <i class="fas fa-box fa-5x text-muted opacity-25"></i>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="d-flex flex-column h-100 justify-content-center pe-md-4">
                <div class="mb-2">
                    <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">
                        By {{ $product->serviceProvider->user->name ?? 'Unknown Provider' }}
                    </span>
                </div>
                
                <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>
                
                <h2 class="text-primary fw-bold mb-4">${{ number_format($product->price, 2) }}</h2>
                
                <div class="mb-4 text-muted" style="line-height: 1.8;">
                    {{ $product->description }}
                </div>
                
                <hr class="mb-4">
                
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="fw-bold">
                        <i class="fas fa-boxes text-primary me-2"></i> 
                        Availability: 
                        @if($product->stock > 0)
                            <span class="text-success">{{ $product->stock }} in stock</span>
                        @else
                            <span class="text-danger">Out of stock</span>
                        @endif
                    </div>
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-3 align-items-center">
                        @csrf
                        <div class="input-group" style="width: 140px;">
                            <button class="btn btn-outline-secondary px-3" type="button" onclick="document.getElementById('quantity').stepDown()">-</button>
                            <input type="number" id="quantity" name="quantity" class="form-control text-center bg-light fw-bold" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button class="btn btn-outline-secondary px-3" type="button" onclick="document.getElementById('quantity').stepUp()">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 flex-grow-1 shadow-sm fs-6 fw-bold">
                            <i class="fas fa-cart-shopping me-2"></i> Add to Cart
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning text-center rounded-4 fw-bold">
                        Temporarily out of stock
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
