@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center ">
    <h4 class="text-uppercase">Members List</h4>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
        Add Member
    </button>
</div>

<div class="container my-5 py-5">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!--Section: Table Block-->
    <section>

        <div class="d-flex justify-content-end">
            <div class="input-group rounded w-25 mb-5">
                <!--<form action="{{ route('searchDepartment') }}" method="get">-->
                <!--    <div class="input-group">-->
                <!--        <input type="text" class="form-control" placeholder="Search..." name="search">-->
                <!--        <button type="submit" class="input-group-text border-0 bg-transparent" id="search-addon"-->
                <!--            style="display: inline;">-->
                <!--            <i class="fas fa-search"></i>-->
                <!--        </button>-->
                <!--    </div>-->
                <!--</form>-->
            </div>
        </div>

        <!-- Members Table -->
        <div class="w-100 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle mb-4 text-center bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-wrap">NO</th>
                                <th class="text-wrap">Name</th>
                                <th class="text-wrap">Guardian</th>
                                <th class="text-wrap">Relationship</th>
                                <th class="text-wrap">Telephone</th>
                                <th class="text-wrap">Email</th>
                                <th class="text-wrap">Role</th>
                                <th class="text-wrap">District</th>
                                <th class="text-wrap">Join Date</th>
                                <th class="text-wrap">Image</th>
                                @if (auth()->user()->role === 'admin')
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $key => $item)
                            <tr>
                                <td class="text-wrap">{{ $key + 1 }}</td>
                                <td class="text-wrap">{{ $item->name }}</td>
                                <td class="text-wrap">{{ $item->guardian_name }}</td>
                                <td class="text-wrap">{{ $item->user_relationship }}</td>
                                <td class="text-wrap">{{ $item->phone }}</td>
                                <td class="text-wrap">
                                    <span class="d-inline-block text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $item->email }}">
                                        {{ $item->email }}
                                    </span>
                                </td>
                                <td class="text-wrap">{{ ucfirst($item->role) }}</td>
                                <td class="text-wrap">{{ $item->district }}</td>
                                <td class="text-wrap">{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                <td class="text-wrap">
                                    <img 
                                        src="{{ url('storage/uploads/' . $item->user_image) }}" 
                                        alt="User Image" 
                                        class="img-thumbnail" 
                                        style="max-width:50px; max-height:50px; cursor: pointer;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#imageModal" 
                                        data-image="{{ url('storage/uploads/' . $item->user_image) }}"
                                    >
                                </td>
                                 @if (auth()->user()->role === 'admin')
                                <td class="text-wrap">
                                    <a class="btn btn-success rounded-pill fw-bold text-white"
                                        href="{{ route('editUser', $item->id) }}">Edit</a>
                                    <a class="btn btn-danger rounded-pill fw-bold text-white"
                                        href="{{ route('delete', $item->id) }}">Delete</a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg for larger size -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Member Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" alt="Member Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                    </div>
                
                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" name="role" required>
                            <option value="member" selected>Member</option>
                            <option value="admin">Admin</option>
                            <option value="accountant">Accountant</option>
                            <option value="secretary">Secretary</option>
                        </select>
                    </div>
                
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                    </div>
                
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    </div>
                
                    <!-- Guardian -->
                    <div class="mb-3">
                        <label for="guardID" class="form-label">Guardian</label>
                        <select class="form-control" name="guardID">
                            @foreach ($departments as $guardian)
                                <option value="{{ $guardian->id }}">{{ $guardian->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Relationship Type -->
                    <div class="mb-3">
                        <label for="relationship_type" class="form-label">Relationship Type</label>
                        <select class="form-control" name="user_relationship" id="user_relationship" required>
                            <option value="" disabled selected>Select a relationship type</option>
                            <option value="mother">Mother</option>
                            <option value="father">Father</option>
                            <option value="spouse">Spouse</option>
                            <option value="sibling">Sibling</option>
                            <option value="child">Child</option>
                            <option value="friend">Friend</option>
                            <option value="colleague">Colleague</option>
                            <option value="neighbor">Neighbor</option>
                            <option value="guardian">Guardian</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                
                    <!-- National ID -->
                    <div class="mb-3">
                        <label for="idcard" class="form-label">National ID</label>
                        <input type="text" class="form-control" name="idcard" maxlength="16" placeholder="Enter 16 digits" required>
                    </div>
                
                    <!-- Phone Number -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" maxlength="10" placeholder="Enter phone number" required>
                    </div>
                
                    <!-- District -->
                    <div class="mb-3">
                        <label for="district" class="form-label">District</label>
                        <input type="text" class="form-control" name="district" placeholder="Enter district" required>
                    </div>
                
                    <!-- Sector -->
                    <div class="mb-3">
                        <label for="sector" class="form-label">Sector</label>
                        <input type="text" class="form-control" name="sector" placeholder="Enter sector" required>
                    </div>
                
                    <!-- Image (optional) -->
                    <div class="mb-3">
                        <label for="user_image" class="form-label">Profile Image (optional)</label>
                        <input type="file" class="form-control" name="user_image">
                    </div>
                
                    <!-- Submit Button -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Create</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
                
                
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg for larger size -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Member Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" alt="Member Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Handle Image Modal and Tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Handle Image Modal
        var imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function (event) {
            var img = event.relatedTarget; // Image that triggered the modal
            var imageSrc = img.getAttribute('data-image'); // Extract info from data-* attributes
            var modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageSrc;
            modalImage.alt = img.alt;
        });
    });
</script>

<!-- Optional: Custom CSS for Better Table Layout -->
<style>
    /* Allow table cells to wrap text */
    .table td, .table th {
        white-space: normal; /* Allows text to wrap */
        word-wrap: break-word; /* Breaks long words */
    }

    /* Optional: Adjust table layout for better readability */
    .table th, .table td {
        vertical-align: middle; /* Vertically center content */
    }
</style>

@endsection
