@extends('admin.master')

@section('content')
    <div class="shadow p-4 d-flex justify-content-between align-items-center ">
        <h4 class="text-uppercase">Edit punishment</h4>
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
            <div class="d-flex gap-5 justify-content-center align-content-center ">

                {{-- Department Form start --}}
                <div class="text-left w-50 ">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="text-uppercase">Update Punishment</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('punishment.punishmentUpdate', $department->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label" for="memberID">Member</label>
                                            <input value="{{ $department->member_name }}" class="form-control"
                                                name= "{{ $department->memberID }}" required>

                                        </div>
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Description</label>
                                            <input  value="{{$department->description}}" placeholder="Enter description" class="form-control" 
                                            name="description"
                                                id="" required>
                                        </div>

                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="form11Example1">Charges</label>
                                            <input   value="{{$department->charges}}" type="number"  class="form-control" name="charges"
                                                id="" required>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="text-center w-25 mx-auto">
                            <button type="submit" class="btn btn-info p-2 rounded">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
