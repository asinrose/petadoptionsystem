@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">My Products</h2>
            <p class="text-muted">Manage the products you sell to pet owners.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="fas fa-plus me-2"></i> Add Product
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm glass-card">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <i class="fas fa-box fa-3x text-muted opacity-50"></i>
                            </div>
                        @endif
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-bold text-dark">{{ $product->name }}</h5>
                                <span class="badge bg-light text-primary rounded-pill px-3">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($product->description, 100) }}
                            </p>
                            
                            <div class="d-flex align-items-center text-muted small mb-3">
                                <i class="fas fa-boxes me-2"></i> Stock: {{ $product->stock }}
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                 <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status_{{ $product->id }}" {{ $product->is_active ? 'checked' : '' }} disabled>
                                    <label class="form-check-label small" for="status_{{ $product->id }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('service-provider.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Product Modal -->
                <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header border-0 bg-light rounded-top-4">
                                <h5 class="modal-title fw-bold">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('service-provider.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase">Product Name</label>
                                        <input type="text" class="form-control bg-light border-0" name="name" value="{{ $product->name }}" required>
                                    </div>
                                    
                                    <div class="row g-3 mb-3">
                                         <div class="col-6">
                                            <label class="form-label fw-bold small text-uppercase">Price ($)</label>
                                            <input type="number" step="0.01" class="form-control bg-light border-0" name="price" value="{{ $product->price }}" required>
                                        </div>
                                        <div class="col-6">
                                             <label class="form-label fw-bold small text-uppercase">Stock</label>
                                             <input type="number" class="form-control bg-light border-0" name="stock" value="{{ $product->stock }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase">Description</label>
                                        <textarea class="form-control bg-light border-0" name="description" rows="3" required>{{ $product->description }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase">Product Image</label>
                                        <input type="file" class="form-control bg-light border-0" name="image" accept="image/*">
                                        @if($product->image)
                                            <small class="text-muted d-block mt-2">Current image will be kept if no new file is selected.</small>
                                        @endif
                                    </div>

                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_status_{{ $product->id }}" {{ $product->is_active ? 'checked' : '' }} value="1">
                                        <label class="form-check-label fw-bold small" for="edit_status_{{ $product->id }}">Active (Visible in shop)</label>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-box-open fa-3x text-muted opacity-25"></i>
                </div>
                <h5 class="text-muted">No products added yet.</h5>
                <p class="text-muted small">Start adding products to sell to pet owners.</p>
            </div>
        @endif
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title fw-bold" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('service-provider.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small text-uppercase">Product Name</label>
                        <input type="text" class="form-control bg-light border-0" id="name" name="name" placeholder="e.g. Premium Dog Food" required>
                    </div>
                    
                    <div class="row g-3 mb-3">
                         <div class="col-6">
                            <label for="price" class="form-label fw-bold small text-uppercase">Price ($)</label>
                            <input type="number" step="0.01" class="form-control bg-light border-0" id="price" name="price" placeholder="0.00" required>
                        </div>
                        <div class="col-6">
                             <label for="stock" class="form-label fw-bold small text-uppercase">Initial Stock</label>
                             <input type="number" class="form-control bg-light border-0" id="stock" name="stock" placeholder="10" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold small text-uppercase">Description</label>
                        <textarea class="form-control bg-light border-0" id="description" name="description" rows="3" placeholder="Describe the product..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold small text-uppercase">Product Image</label>
                        <input type="file" class="form-control bg-light border-0" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked value="1">
                        <label class="form-check-label fw-bold small" for="is_active">Active (Visible in shop)</label>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
