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

    .pet-avatar {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-available { background: #d1fae5; color: #065f46; }
    .status-adopted { background: #e0e7ff; color: #3730a3; }
    .status-lost { background: #fee2e2; color: #b91c1c; }
    .status-found { background: #fef3c7; color: #92400e; }
</style>

<div class="admin-wrapper">
    <div class="container">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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
                    <a href="{{ route('admin.pets') }}" class="active">
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
                    <h4 class="fw-bold mb-0">Pet Management</h4>
                    <button class="btn btn-outline-primary rounded-pill px-4">
                        <i class="fas fa-download me-2"></i> Export Report
                    </button>
                </div>
                
                <div class="table-card">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Pet</th>
                                    <th>Species & Breed</th>
                                    <th>Posted By</th>
                                    <th>Status</th>
                                    <th>Date Posted</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                 @if($pets->count() > 0)
                    @foreach ($pets as $pet)

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/'.$pet->image) }}" class="pet-avatar me-3">
                                            <div>
                                                <span class="fw-bold d-block">{{ $pet->name }}</span>
                                                <small class="text-muted">{{ $pet->age }} old</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ $pet->species }}</span>
                                        <small class="text-muted">{{ $pet->breed }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <small class="fw-semibold">{{ $pet->user->name ?? 'Unknown' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusLower = strtolower($pet->status);
                                            $badgeClass = 'bg-secondary';
                                            if ($statusLower === 'available') $badgeClass = 'status-available';
                                            elseif ($statusLower === 'adopted') $badgeClass = 'status-adopted';
                                            elseif ($statusLower === 'lost') $badgeClass = 'status-lost';
                                            elseif ($statusLower === 'found') $badgeClass = 'status-found';
                                        @endphp
                                        <span class="status-badge {{ $badgeClass }}">
                                            {{ ucfirst($pet->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $pet->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                                Actions <i class="fas fa-chevron-down ms-1" style="font-size: 10px;"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                <li>
                                                    <a class="dropdown-item py-2" href="{{ route('pets.show', $pet) }}" target="_blank">
                                                        <i class="far fa-eye text-primary me-2 w-15px"></i> View Public Page
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#statusModal{{ $pet->id }}">
                                                        <i class="fas fa-tag text-warning me-2 w-15px"></i> Change Status
                                                    </button>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.pets.destroy', $pet) }}" onsubmit="return confirm('Are you sure you want to completely remove this pet listing? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-2 text-danger">
                                                            <i class="far fa-trash-alt me-2 w-15px"></i> Delete Listing
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-paw fa-3x text-muted mb-3 opacity-25"></i>
                                        <p class="text-muted mb-0">No pets found in the system.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-4">
                    {{ $pets->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modals for changing status -->
@foreach($pets as $pet)
<div class="modal fade" id="statusModal{{ $pet->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">Update Pet Status - {{ $pet->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.pets.update_status', $pet) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Status</label>
                        <select name="status" class="form-select rounded-3 p-3">
                            <option value="Available" {{ strtolower($pet->status) === 'available' ? 'selected' : '' }}>Available for Adoption</option>
                            <option value="Adopted" {{ strtolower($pet->status) === 'adopted' ? 'selected' : '' }}>Adopted (Closed)</option>
                            <option value="Lost" {{ strtolower($pet->status) === 'lost' ? 'selected' : '' }}>Lost Pet</option>
                            <option value="Found" {{ strtolower($pet->status) === 'found' ? 'selected' : '' }}>Found Pet</option>
                        </select>
                        <div class="form-text mt-2">
                            Changing the status will immediately update how this pet appears on the public platform.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Save Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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
