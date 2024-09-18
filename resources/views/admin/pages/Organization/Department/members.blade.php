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
                <form action="{{ route('searchDepartment') }}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." name="search">
                        <button type="submit" class="input-group-text border-0 bg-transparent" id="search-addon"
                            style="display: inline;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Members Table -->
        <div class="w-100 card">
            <div class="card-body">
                <table class="table align-middle mb-4 text-center bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>NO</th>
                            <th>Name</th>
                            <th>Guardian</th>
                            <th>Relationship</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>District</th>
                            <th>Join Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->guardian_name }}</td>
                            <td>{{ $item->user_relationship }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->role }}</td>
                            <td>{{ $item->district }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <a class="btn btn-success rounded-pill fw-bold text-white"
                                    href="{{ route('edit', $item->id) }}">Edit</a>
                                <a class="btn btn-danger rounded-pill fw-bold text-white"
                                    href="{{ route('Organization.delete', $item->id) }}">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
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
                            <option value="acountant">Acountant</option>
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

@endsection
