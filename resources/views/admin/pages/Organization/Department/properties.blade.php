@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center ">
    <h4 class="text-uppercase">Property List</h4>
</div>
<div class="container my-5 py-5">

    <!--Section: Form Design Block-->
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
        <div class="d-flex gap-5 justify-content-center align-content-center ">

            {{-- Property Form start --}}
            <div class="text-left w-30 ">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-uppercase">Add Property</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('property.propertyStore') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-outline">
                                        <label class="form-label mt-2" for="name">Name</label>
                                        <input placeholder="Enter Name" class="form-control" name="name" id="name" required>
                                    </div>
                                    <div class="form-outline">
                                        <label class="form-label mt-2" for="location">Location</label>
                                        <input placeholder="Enter Location" class="form-control" name="location" id="location">
                                    </div>
                                    <div class="form-outline">
                                        <label class="form-label mt-2" for="property_value">Property Value</label>
                                        <input type="number" class="form-control" name="property_value" id="property_value" required>
                                    </div>
                                    <div class="form-outline">
                                        <label class="form-label mt-2" for="property_attachment">Property Attachment</label>
                                        <input type="file" class="form-control" name="property_attachment" id="property_attachment" accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                    <div class="form-outline">
                                        <label class="form-label mt-2" for="property_date">Property Date</label>
                                        <input type="date" class="form-control" name="property_date" id="property_date" required>
                                    </div>
                                    <div class="form-outline">
                                        <label class="form-label mt-2" for="comment">Comment</label>
                                        <input placeholder="" class="form-control" name="comment" id="comment">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center w-25 mx-auto">
                                <button type="submit" class="btn btn-success p-2 px-3 rounded-pill">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Property Table start --}}
            <div class="w-75 card">
                <div>
                    <table class="table align-middle mb-4 text-center bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>NO</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Value</th>
                                <th>Attachment</th>
                                <th>Date</th>
                                <th>Comment</th>
                                @if (auth()->user()->role === 'admin')
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $key => $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->location }}</td>
                                <td>{{ $item->property_value }}</td>
                                <td>
                                    @if($item->property_attachment)
                                        <a href="{{ url('storage/'.$item->property_attachment) }}" target="_blank">View Attachment</a>
                                    @endif
                                </td>
                                <td>{{ $item->property_date }}</td>
                                <td>{{ $item->comment }}</td>
                                @if (auth()->user()->role === 'admin')
                                <td>
                                    <a class="btn btn-success rounded-pill fw-bold text-white" href="{{ route('property.propertyEdit', $item->id) }}">Edit</a>
                                    <a class="btn btn-danger rounded-pill fw-bold text-white" href="{{ route('property.deleteProperty', $item->id) }}">Delete</a>
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
@endsection
