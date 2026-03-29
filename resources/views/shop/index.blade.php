@extends('layouts.app')

@section('content')
<style>
    .shop-header {
        background: linear-gradient(135deg, #6C63FF 0%, #a29bfe 100%);
        color: white;
        padding: 4rem 0;
        margin-bottom: -3rem;
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

    .product-img-wrapper {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .glass-card:hover .product-img {
        transform: scale(1.05);
    }

    .price-tag {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        color: #6C63FF;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 2;
    }

    .search-bar {
        background: white;
        border-radius: 50px;
        padding: 0.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .search-input {
        border: none;
        padding-left: 1.5rem;
        background: transparent;
    }

    .search-input:focus {
        box-shadow: none;
        outline: none;
    }

    .search-btn {
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
    }
</style>

<div class="shop-header text-center">
    <div class="container pb-5">
        <h1 class="display-4 fw-bold mb-3">Pet Supplies Shop <i class="fas fa-shopping-bag ms-2"></i></h1>
        <p class="lead opacity-90 mb-4">Discover premium products for your furry friends from trusted providers.</p>
        
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form action="{{ route('shop.index') }}" method="GET" class="search-bar d-flex align-items-center">
                    <i class="fas fa-search text-muted ms-3"></i>
                    <input type="text" name="search" class="form-control search-input" placeholder="Search for toys, food, accessories..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary search-btn fw-bold">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5" style="margin-top: -2rem; position: relative; z-index: 1;">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 rounded-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
  
                    @forelse ($products as $product)

            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 glass-card text-decoration-none">
                    <a href="{{ route('shop.show', $product) }}" class="text-decoration-none text-dark d-block">
                        <div class="product-img-wrapper">
                            <span class="price-tag">${{ number_format($product->price, 2) }}</span>
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" class="product-img" alt="{{ $product->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <i class="fas fa-box fa-4x text-muted opacity-25"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold text-truncate mb-2">{{ $product->name }}</h5>
                            <p class="card-text text-muted small mb-3 text-truncate">
                                By {{ $product->serviceProvider->user->name ?? 'Unknown Provider' }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="small border bg-light rounded-pill px-3 py-1">
                                    <i class="fas fa-boxes text-primary me-1"></i> {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="card-footer bg-white border-top-0 p-4 pt-0">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary w-100 rounded-pill fw-bold">
                                    <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary w-100 rounded-pill fw-bold" disabled>
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 mt-5">
                <br>
                <i class="fas fa-search fa-3x text-muted mb-3 opacity-25"></i>
                <h4 class="text-muted fw-bold">No products found</h4>
                <p class="text-muted">We couldn't find any products matching your criteria.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill px-4 mt-2">Clear Search</a>
            </div>
        @endforelse
    </div>
    
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>
@endsection
