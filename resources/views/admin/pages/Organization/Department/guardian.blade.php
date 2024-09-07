@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center">
    <h4 class="text-uppercase">Guardians List</h4>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGuardianModal">
        Add Guardian
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
        <div class="d-flex justify-content-end mb-4">
            <div class="input-group rounded w-25">
                <form action="{{ route('searchDepartment') }}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." name="search">
                        <button type="submit" class="input-group-text border-0 bg-transparent" id="search-addon">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Guardians Table -->
        <div class="w-100 card">
            <div class="card-body">
                <table class="table align-middle mb-4 text-center bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>NO</th>
                            <th>Name</th>
                            <th>National ID</th>
                            <th>Phone</th>
                            <th>District</th>
                            <th>Sector</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guardians as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->idcard }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->district }}</td>
                            <td>{{ $item->sector }}</td>
                            <td><img src="{{ url('storage/uploads/' . $item->guardian_image) }}" alt="Guardian Image" style="width:50px; height:50px;"></td>
                            <td>
                                <a class="btn btn-success rounded-pill fw-bold text-white"
                                    href="{{ route('Organization.edit', $item->id) }}">Edit</a>
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

<!-- Add Guardian Modal -->
<div class="modal fade" id="addGuardianModal" tabindex="-1" aria-labelledby="addGuardianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGuardianModalLabel">Add Guardian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('organization.department.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="idcard" class="form-label">National ID</label>
                        <input type="number" class="form-control" name="idcard" placeholder="Enter 16 DIGIT" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="number" class="form-control" name="phone" placeholder="Enter phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="district" class="form-label">District</label>
                        <input type="text" class="form-control" name="district" placeholder="Enter district" required>
                    </div>
                    <div class="mb-3">
                        <label for="sector" class="form-label">Sector</label>
                        <input type="text" class="form-control" name="sector" placeholder="Enter sector" required>
                    </div>

                      <!-- Image (optional) -->
                      <div class="mb-3">
                        <label for="user_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" name="guardian_image">
                    </div>
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
