@extends('layouts.app')

@section('content')

<style>
    .profile-wrapper {
        background: #f9fafb;
        padding: 40px 0;
    }

    .profile-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .profile-layout {
        display: flex;
        min-height: 600px;
    }

    /* LEFT SIDEBAR */
    .profile-sidebar {
        width: 260px;
        border-right: 1px solid #eee;
        padding: 30px 20px;
        background: #fff;
        flex-shrink: 0;
    }

    .profile-sidebar h5 {
        font-weight: 700;
        margin-bottom: 30px;
    }

    .profile-menu a,
    .profile-menu button {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-radius: 10px;
        color: #555;
        text-decoration: none;
        margin-bottom: 10px;
        font-weight: 500;
        width: 100%;
    }

    .profile-menu i {
        width: 22px;
        margin-right: 12px;
    }

    .profile-menu a.active {
        background: #fff1ec;
        color: #ff6a3d;
        border-left: 4px solid #ff6a3d;
    }

    .profile-menu .logout {
        color: #ff3b3b;
        margin-top: 40px;
    }

    /* RIGHT CONTENT */
    .profile-content {
        padding: 40px;
        flex: 1;
    }

    .application-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .application-card:hover {
        border-color: #ff6a3d;
        box-shadow: 0 5px 15px rgba(255,106,61,0.1);
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-approved { background: #d4edda; color: #155724; }
    .status-rejected { background: #f8d7da; color: #721c24; }

    @media (max-width: 991px) {
        .profile-layout {
            flex-direction: column;
        }

        .profile-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #eee;
        }
    }
</style>

<div class="container profile-wrapper">
    <div class="profile-card">
        <div class="profile-layout">

            <!-- LEFT SIDEBAR -->
            <div class="profile-sidebar">
                <h5>User Profile</h5>

                <div class="profile-menu">
                    <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> User info</a>
                    <a href="{{ route('pets.my_pets') }}"><i class="fas fa-paw"></i> My Pets</a>
                    <a href="{{ route('profile.favorites') }}"><i class="far fa-heart"></i> Favorites</a>
                    <a href="{{ route('pets.create') }}"><i class="fas fa-plus"></i> Add pet</a>
                    <a href="{{ route('profile.booked_services') }}"><i class="far fa-calendar-alt"></i> Booked Services</a>
                    <a href="{{ route('profile.booked_pets') }}"><i class="fas fa-bone"></i> Booked Pets</a>
                    <a href="{{ route('profile.applications') }}" class="active"><i class="fas fa-paw"></i> Adoption Applications</a>

                    <!-- Logout trigger -->
                    <button type="button"
                            class="btn border-0 bg-transparent text-start logout"
                            data-bs-toggle="modal"
                            data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </button>
                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="profile-content">

                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Adoption Applications</h4>
                    <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">{{ $applications->count() }} Requests</span>
                </div>

                <p class="text-muted mb-4">Here are the adoption requests submitted by users for your posted pets.</p>

                @if($applications->count() > 0)
                    @foreach ($applications as $application)
                    <div class="application-card p-4 mb-4">
                        <div class="row align-items-center">
                            <!-- Pet Info Col -->
                            <div class="col-md-5 mb-3 mb-md-0 d-flex align-items-center">
                                <img src="{{ $application->pet->image ? asset('images/'.$application->pet->image) : 'https://placehold.co/100x100?text=Pet' }}" 
                                     alt="{{ $application->pet->name }}"
                                     class="rounded-circle me-3 object-fit-cover shadow-sm"
                                     style="width: 70px; height: 70px;">
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        <a href="{{ route('pets.show', $application->pet->id) }}" class="text-decoration-none text-dark hover-primary">{{ $application->pet->name }}</a>
                                    </h5>
                                    <p class="text-muted small mb-0"><i class="fas fa-paw me-1"></i> {{ $application->pet->breed }}</p>
                                </div>
                            </div>
                            
                            <!-- Requester Info Col -->
                            <div class="col-md-5 mb-3 mb-md-0 border-start border-md-0 ps-md-4">
                                <div class="text-uppercase text-muted small fw-bold mb-2">Requester Info</div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-user-circle text-primary me-2 fs-5"></i>
                                    <span class="fw-semibold">{{ $application->user->name }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    <a href="mailto:{{ $application->user->email }}" class="text-muted text-decoration-none">{{ $application->user->email }}</a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone-alt text-muted me-2"></i>
                                    <span class="text-muted">{{ $application->user->contact ?: 'No contact provided' }}</span>
                                </div>
                            </div>

                            <!-- Status Col -->
                            <div class="col-md-2 text-md-end text-start border-start border-md-0 pt-3 pt-md-0">
                                <div class="text-uppercase text-muted small fw-bold mb-2 d-md-block d-inline-block">Status & Date</div>
                                <div class="mb-2 d-md-block d-inline-block ms-2 ms-md-0">
                                    <span class="status-badge status-{{ $application->status }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                                <div class="text-muted small">
                                    {{ \Carbon\Carbon::parse($application->request_date)->diffForHumans() }}
                                </div>
                                @if($application->status === 'pending')
                                    <div class="d-flex flex-column gap-2 mt-3">
                                        <form action="{{ route('profile.applications.update_status', $application->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success w-100 rounded-pill shadow-sm text-white fw-bold">Accept</button>
                                        </form>
                                        <form action="{{ route('profile.applications.update_status', $application->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill shadow-sm fw-bold">Reject</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-5 bg-light rounded-4">
                        <div class="mb-3">
                            <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-muted fw-bold">No Applications Yet</h5>
                        <p class="text-muted">You haven't received any adoption applications for your pets.</p>
                    </div>
                @endif

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
