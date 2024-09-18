@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center ">
    <h4 class="text-uppercase">Expenduture</h4>
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
                        <h6 class="text-uppercase">Add Expenduture</h>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('expenduture.expendutureStore') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label" for="memberID">Category</label>
                                            <select class="form-control" name="category_id">
                                                @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                        
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="description">Description</label>
                                            <input class="form-control" name="description" id="description">
                                        </div>
                        
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="amount">Amount</label>
                                            <input type="number" min="1" class="form-control" name="amount" id="amount" required>
                                        </div>
                        
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="date">Date</label>
                                            <input type="date" class="form-control" name="date" id="date" required>
                                        </div>
                        
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="meeting_attachment">Attachment</label>
                                            <input type="file" class="form-control" name="meeting_attachment" id="meeting_attachment">
                                        </div>
                        
                                        {{-- Optional Employee Field --}}
                                        {{-- <div class="form-outline">
                                            <label class="form-label mt-2" for="employee_id">Employee</label>
                                            <input type="text" class="form-control" name="employee_id" id="employee_id">
                                        </div> --}}
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
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Attachment</th>
                                
                                {{-- <th>Bank Name</th> --}}

                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenditures as  $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->category_name }}</td>
                                <td>
                                    @if($item->meeting_attachment)
                                        <a href="{{ url('storage/uploads/'.$item->meeting_attachment) }}" target="_blank">View Attachment</a>
                                    @endif
                                </td>


                                {{-- <td>
                                    <a class="btn btn-success rounded-pill fw-bold text-white"
                                        href="{{ route('expenduture.expendutureEdit', $item->id) }}">Edit</a>
                                    <a class="btn btn-danger rounded-pill fw-bold text-white"
                                        href="{{ route('expenduture.expendutureDelete', $item->id) }}">Delete</a>
                                </td> --}}
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