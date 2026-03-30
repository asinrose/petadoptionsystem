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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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

        .admin-menu a:hover,
        .admin-menu a.active {
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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
            width: 45px;
            height: 45px;
            border-radius: 8px;
            object-fit: cover;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #b91c1c;
        }
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
                        <a href="{{ route('admin.pets') }}">
                            <i class="fas fa-paw"></i> Pet Management
                        </a>
                        <a href="{{ route('admin.products') }}">
                            <i class="fas fa-box-open"></i> Products
                        </a>
                        <a href="{{ route('admin.orders') }}">
                            <i class="fas fa-shopping-cart"></i> Orders
                        </a>
                        <a href="{{ route('admin.adoptions') }}" class="active">
                            <i class="fas fa-hand-holding-heart"></i> Adoptions
                        </a>


                        <hr class="my-3">

                        <!-- Logout trigger -->
                        <button type="button" class="btn border-0 bg-transparent text-start w-100 px-3 text-danger"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt"></i> Log out
                        </button>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Adoption Requests</h4>
                        <span class="badge bg-primary rounded-pill px-3 py-2">Total Requests:
                            {{ $adoptions->total() }}</span>
                    </div>

                    <div class="table-card">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Pet</th>
                                        <th>Requester</th>
                                        <th>Email</th>
                                        <th>Date Requested</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($adoptions as $adoption)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('images/' . $adoption->pet->image) }}"
                                                        class="pet-avatar me-3">
                                                    <div>
                                                        <span class="fw-bold d-block">{{ $adoption->pet->name }}</span>
                                                        <small class="text-muted">{{ $adoption->pet->breed }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ $adoption->user->name }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $adoption->user->email }}</small>
                                            </td>
                                            <td>{{ $adoption->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @php
                                                    $status = strtolower($adoption->status);
                                                    $badgeClass = 'status-pending';
                                                    if ($status === 'approved')
                                                        $badgeClass = 'status-approved';
                                                    elseif ($status === 'rejected')
                                                        $badgeClass = 'status-rejected';
                                                @endphp
                                                <span class="status-badge {{ $badgeClass }}">
                                                    {{ ucfirst($adoption->status) }}
                                                </span>
                                            </td>

                                        </tr>

                                        <!-- Status Modal -->
                                        <div class="modal fade" id="statusModal{{ $adoption->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 rounded-4 shadow">
                                                    <div class="modal-header border-bottom">
                                                        <h5 class="modal-title fw-bold">Update Adoption Status</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.adoptions.update_status', $adoption->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body p-4">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">New Status</label>
                                                                <select name="status" class="form-select rounded-3">
                                                                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending Review</option>
                                                                    <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approve Request</option>
                                                                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Reject Request</option>
                                                                </select>
                                                            </div>
                                                            <p class="text-muted small mb-0">Updating the status will notify the
                                                                user about the decision regarding their adoption application.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer border-top bg-light rounded-bottom-4">
                                                            <button type="button" class="btn btn-secondary rounded-pill px-4"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit"
                                                                class="btn btn-primary rounded-pill px-4">Update Status</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <i class="fas fa-hand-holding-heart fa-3x text-muted mb-3 opacity-25"></i>
                                                <p class="text-muted mb-0">No adoption requests found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $adoptions->links() }}
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
                    <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-danger rounded-pill px-4">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection