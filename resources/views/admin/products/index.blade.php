@extends('layouts.app')

@section('content')
<style>
    .admin-wrapper {
        background: #f4f6f9;
        min-height: calc(100vh - 80px);
        padding: 30px 0;
    }

    .admin-menu {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .admin-menu a {
        display: block;
        padding: 12px 15px;
        color: #555;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        margin-bottom: 5px;
        transition: all 0.2s;
    }

    .admin-menu a:hover, .admin-menu a.active {
        background: #f3e5f5;
        color: #9c27b0;
    }

    .admin-menu i {
        width: 25px;
        text-align: center;
        margin-right: 10px;
    }

    .content-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
</style>

<div class="admin-wrapper">
    <div class="container">
        <div class="row g-4">
            
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="admin-menu">
                    <h5 class="fw-bold mb-4 px-3">Admin Panel</h5>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}">
                        <i class="fas fa-users"></i> User Management
                    </a>
                    <a href="{{ route('admin.pets') }}">
                        <i class="fas fa-paw"></i> Pet Management
                    </a>
                    <a href="{{ route('admin.products') }}" class="active">
                        <i class="fas fa-box-open"></i> Products
                    </a>
                    <a href="{{ route('admin.orders') }}">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                    <a href="#">
                        <i class="fas fa-hand-holding-heart"></i> Adoptions
                    </a>
                    <a href="#">
                        <i class="fas fa-briefcase"></i> Service Providers
                    </a>
                    
                    <hr class="my-3">
                    
                    <!-- Logout trigger -->
                    <button type="button" 
                            class="btn border-0 bg-transparent text-start w-100 px-3 text-danger"
                            data-bs-toggle="modal" 
                            data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </button>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-purple" style="color: #9c27b0;">Product Listings</h4>
                        <span class="badge bg-purple rounded-pill px-3 py-2" style="background-color: #9c27b0;">Total: {{ $products->total() }}</span>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Product info</th>
                                    <th>Provider</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                 @if($products->count() > 0)
                    @foreach ($products as $product)

                                <tr>
                                    <td>#{{ $product->id }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 40px; height: 40px;">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($product->name, 20) }}</div>
                                        <div class="small text-muted">{{ $product->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $product->serviceProvider->user->name ?? 'Unknown' }}</span>
                                    </td>
                                    <td class="fw-bold text-success">${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        @if($product->stock > 10)
                                            <span class="text-success fw-bold">{{ $product->stock }}</span>
                                        @elseif($product->stock > 0)
                                            <span class="text-warning fw-bold">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Out of stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('shop.show', $product) }}" target="_blank" class="btn btn-outline-primary" title="View in Shop">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Delete Product" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        No products found in the platform yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
