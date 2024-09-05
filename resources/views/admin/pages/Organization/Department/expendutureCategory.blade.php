@extends('admin.master')

@section('content')
    <div class="shadow p-4 d-flex justify-content-between align-items-center ">
        <h4 class="text-uppercase">Expenduture Category</h4>
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

                {{-- Department Form start --}}
                <div class="text-left w-30 ">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="text-uppercase">Add Category</h>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('organization.expendutureCategoryStore') }}" method="post">
                                @csrf
                                <div class="row mb-4">
                                    <div class=" col">
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label mt-2" for="form11Example1">Category</label>
                                                <input class="form-control" name="name" id="" required>
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
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a class="btn btn-success rounded-pill fw-bold text-white"
                                                href="{{ route('organization.expendutureCategoryEdit', $item->id) }}">Edit</a>
                                            <a class="btn btn-danger rounded-pill fw-bold text-white"
                                                href="{{ route('organization.expendutureCategoryDelete', $item->id) }}">Delete</a>
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
