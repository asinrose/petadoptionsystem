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
        background: #fffde7;
        color: #fbc02d;
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
                    <a href="{{ route('admin.products') }}">
                        <i class="fas fa-box-open"></i> Products
                    </a>
                    <a href="{{ route('admin.orders') }}" class="active">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                    <a href="{{ route('admin.adoptions') }}">
                        <i class="fas fa-hand-holding-heart"></i> Adoptions
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
                        <h4 class="fw-bold mb-0 text-warning" style="color: #fbc02d !important;">Platform Orders</h4>
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Total: {{ $orders->total() }}</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                    @forelse ($orders as $order)

                                <tr>
                                    <td class="fw-bold text-muted">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ substr($order->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold small">{{ $order->user->name ?? 'Unknown User' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">{{ $order->created_at->format('M d, Y') }}</div>
                                        <div class="small text-muted">{{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="fw-bold text-success">${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ preg_replace('/[^A-Za-z0-9]/', ' ', ucfirst($order->payment_method)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-warning text-dark',
                                                'processing' => 'bg-info text-white',
                                                'completed' => 'bg-success text-white',
                                                'cancelled' => 'bg-danger text-white',
                                            ];
                                            $statusClass = $statusColors[$order->status] ?? 'bg-secondary text-white';
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill px-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-shopping-basket fa-3x mb-3 opacity-25"></i>
                                        <p>No orders have been placed on the platform yet.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
