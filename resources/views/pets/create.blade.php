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

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px;
    }

    .save-btn {
        background: #ff6a3d;
        color: #fff;
        border-radius: 30px;
        padding: 12px 50px;
        border: none;
        font-weight: 600;
        box-shadow: 0 10px 25px rgba(255,106,61,0.35);
    }

    .save-btn:hover {
        background: #ff5722;
    }

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
                    <a href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i> User info
                    </a>
                    <a href="{{ route('pets.my_pets') }}"><i class="fas fa-paw"></i> My Pets</a>
                    <a href="{{ route('profile.favorites') }}"><i class="far fa-heart"></i> Favorites</a>
                    <a href="{{ route('pets.create') }}" class="active"><i class="far fa-plus"></i> Add pet</a>
                    <a href="{{ route('profile.booked_services') }}"><i class="far fa-calendar-alt"></i> Booked Services</a>
                    <a href="{{ route('profile.applications') }}"><i class="fas fa-paw"></i> Adoption Applications</a>

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

                <h4 class="mb-4">Add a New Pet for Adoption</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Pet Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Breed</label>
                            <input type="text" name="breed" class="form-control" value="{{ old('breed') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Age (Years/Months)</label>
                            <input type="number" name="age" class="form-control" value="{{ old('age') }}" required min="0">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control form-select" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                         <div class="col-md-4">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-control form-select" required>
                                <option value="">Select Type</option>
                                <option value="dog" {{ old('type') == 'dog' ? 'selected' : '' }}>Dog</option>
                                <option value="cat" {{ old('type') == 'cat' ? 'selected' : '' }}>Cat</option>
                                <option value="bird" {{ old('type') == 'bird' ? 'selected' : '' }}>Bird</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact" class="form-control" value="{{ old('contact') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Location/Address</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                        </div>

                        <!-- New Fields -->
                        <div class="col-md-4">
                            <label class="form-label">Weight (kg) <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="weight" class="form-control" value="{{ old('weight') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vaccination Status</label>
                            <select name="vaccination_status" class="form-control form-select" required>
                                <option value="not_vaccinated" {{ old('vaccination_status') == 'not_vaccinated' ? 'selected' : '' }}>Not Vaccinated</option>
                                <option value="vaccinated" {{ old('vaccination_status') == 'vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vaccination Date</label>
                            <input type="date" name="vaccination_date" class="form-control" value="{{ old('vaccination_date') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Dewormed?</label>
                            <select name="dewormed" class="form-control form-select" required>
                                <option value="0" {{ old('dewormed') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('dewormed') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Adoption Type</label>
                            <select name="adoption_type" class="form-control form-select" required id="adoptionType">
                                <option value="free" {{ old('adoption_type') == 'free' ? 'selected' : '' }}>Free Adoption</option>
                                <option value="fee" {{ old('adoption_type') == 'fee' ? 'selected' : '' }}>Adoption Fee</option>
                            </select>
                        </div>

                        <div class="col-md-4" id="feeInput" style="display: none;">
                            <label class="form-label">Adoption Fee ($)</label>
                            <input type="number" name="adoption_fee" class="form-control" value="{{ old('adoption_fee') }}" step="0.01" min="0">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Medical Conditions <span class="text-muted">(If any)</span></label>
                            <textarea name="medical_conditions" class="form-control" rows="2">{{ old('medical_conditions') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Special Care Requirements</label>
                            <textarea name="special_care_requirements" class="form-control" rows="2">{{ old('special_care_requirements') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const typeSelect = document.getElementById('adoptionType');
                                const feeInput = document.getElementById('feeInput');

                                function toggleFee() {
                                    if (typeSelect.value === 'fee') {
                                        feeInput.style.display = 'block';
                                    } else {
                                        feeInput.style.display = 'none';
                                    }
                                }

                                typeSelect.addEventListener('change', toggleFee);
                                toggleFee(); // Run on load
                            });
                        </script>

                        <div class="col-12">
                            <label class="form-label">Pet Photo</label>
                            <input type="file" name="image" class="form-control" required accept="image/*">
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <button type="submit" class="save-btn">Post Pet</button>
                    </div>
                </form>

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
