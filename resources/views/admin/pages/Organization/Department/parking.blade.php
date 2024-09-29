@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center ">
    <h4 class="text-uppercase">Parking</h4>
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

            {{-- Department Form start --}}
            <div class="text-left w-30 ">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-uppercase">Parking</h>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('punishment.ParkingStore') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class=" col">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Member</label>
                                            <select type="text" class="form-control" name="userID">
                                                @foreach ($departments as $department)
                                                <option value="{{$department->id}}">{{ $department->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Punishment Type</label>
                                            <input  class="form-control" name="description"
                                                id="" required>
                                        </div> --}}


                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Fees/Umusanzu</label>
                                            <input type="number"  class="form-control" name="cost"
                                                id="" required>
                                        </div>


                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Charges/Amande</label>
                                            <input type="number"  class="form-control" name="charges"
                                                id="" >
                                        </div>

                                        
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Date</label>
                                            <input type="date" class="form-control" name='parking_date' 
                                                id="" >
                                        </div>


                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Comment</label>
                                            <input  class="form-control" name="description"
                                                id="" >
                                        </div>

                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Attachment</label>
                                            <input type="file"  class="form-control" name="attachment"
                                                id="" >
                                        </div>
                                                                               
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

            {{-- Department Table start --}}
            <div class="w-75 card">
                <div>
                    <table class="table align-middle mb-4 text-center bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>NO</th>
                                <th>Member Name</th>
                                <th>Reason</th>
                                <th>Fees</th>
                                <th>Charges</th>
                                <th>Date</th>


                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as  $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->member_name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->cost }}</td>
                                <td>{{ $item->charges }}</td>
                                <td>{{ $item->parking_date }}</td>



                                <td>
                                    <a class="btn btn-success rounded-pill fw-bold text-white"
                                        href="{{ route('parking.parkingEdit', $item->id) }}">Edit</a>
                                    {{-- <a class="btn btn-danger rounded-pill fw-bold text-white"
                                        href="{{ route('punishment.Deletepunishment', $item->id) }}">Delete</a> --}}
                                </td>
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