@extends('layouts.app')

@section('content')

<style>
    .admin-wrapper {
        background: #f4f6f9;
        min-height: calc(100vh - 80px); /* Adjust based on navbar height */
        padding: 30px 0;
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        border-left: 5px solid #ff6a3d;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: #fff1ec;
        color: #ff6a3d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #777;
        font-size: 0.9rem;
        font-weight: 500;
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
        background: #fff1ec;
        color: #ff6a3d;
    }

    .admin-menu i {
        width: 25px;
        text-align: center;
        margin-right: 10px;
    }

    .recent-table-card {
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
                    <a href="{{ route('admin.dashboard') }}" class="active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}">
                        <i class="fas fa-users"></i> User Management
                    </a>
                    <a href="{{ route('admin.pets') }}">
                        <i class="fas fa-paw"></i> Pet Management
                    </a>
                    <a href="#">
                        <i class="fas fa-hand-holding-heart"></i> Adoptions
                    </a>
                    <a href="#">
                        <i class="fas fa-briefcase"></i> Service Providers
                    </a>
                    <a href="#">
                        <i class="fas fa-cog"></i> Settings
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
                <h4 class="mb-4 fw-bold">Dashboard Overview</h4>
                
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-value">{{ $totalUsers }}</div>
                            <div class="stat-label">Registered Users</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="border-left-color: #4facfe;">
                            <div class="stat-icon" style="background: #e6f7ff; color: #4facfe;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="stat-value">{{ $totalServiceProviders }}</div>
                            <div class="stat-label">Service Providers</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="border-left-color: #00f260;">
                            <div class="stat-icon" style="background: #e6fffa; color: #00f260;">
                                <i class="fas fa-paw"></i>
                            </div>
                            <div class="stat-value">{{ $totalPets }}</div>
                            <div class="stat-label">Total Pets Posted</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="border-left-color: #ffb199;">
                            <div class="stat-icon" style="background: #fff5f2; color: #ffb199;">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="stat-value">{{ $adoptedPets }}</div>
                            <div class="stat-label">Pets Adopted</div>
                        </div>
                    </div>
                </div>

                <!-- Placeholder for future charts or lists -->
                <div class="recent-table-card">
                    <h5 class="fw-bold mb-3">System Health</h5>
                    <p class="text-muted">System is running smoothly. More analytics coming soon.</p>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- LOGOUT MODAL -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="text-muted mb-0">Are you sure you want to log out?</p>
            </div>

            <div class="modal-footer border-0 justify-content-center gap-2">
                <button class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Cancel</button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger rounded-pill px-4">Log out</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
