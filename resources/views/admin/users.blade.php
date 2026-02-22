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
        background: #fff1ec;
        color: #ff6a3d;
    }

    .admin-menu i {
        width: 25px;
        text-align: center;
        margin-right: 10px;
    }

    .table-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #eee;
        color: #555;
        font-weight: 600;
        padding: 15px;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .role-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .role-admin { background: #fee2e2; color: #b91c1c; }
    .role-user { background: #dbeafe; color: #1e40af; }
    .role-service_provider { background: #e0e7ff; color: #3730a3; }
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
                    <a href="{{ route('admin.users') }}" class="active">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">User Management</h4>
                    <button class="btn btn-outline-primary rounded-pill px-4">
                        <i class="fas fa-download me-2"></i> Export Report
                    </button>
                </div>
                
                <div class="table-card">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="user-avatar me-3">
                                            <span class="fw-bold">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="role-badge role-{{ $user->role }}">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success rounded-pill">Active</span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-4">
                    {{ $users->links() }}
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
