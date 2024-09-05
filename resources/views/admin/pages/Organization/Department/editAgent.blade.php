@extends('admin.master')

@section('content')
    <div class="shadow p-4 d-flex justify-content-between align-items-center ">
        <h4 class="text-uppercase">Edit Agent</h4>
    </div>
    <div class="container my-5 py-5">

        <!--Section: Form Design Block-->
        <section>
            <div class="d-flex gap-5 justify-content-center align-content-center ">

                {{-- Department Form start --}}
                <div class="text-left w-50 ">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="text-uppercase">Update Agent</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('agent.agentUpdate', $department->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="row mb-4">
                                    <div class=" col">
                                        <div class="col">

                                            <div class="form-outline">
                                                <label class="form-label mt-2" for="form11Example1">Names</label>
                                                <input value="{{ $department->name }}" placeholder="Enter Name"
                                                    class="form-control" name="name" id="" required>
                                            </div>
                                           
                                            <div class="form-outline">
                                                <label class="form-label mt-2" for="form11Example1">Service</label>
                                                <input value="{{ $department->service }}" type="text"
                                                     class="form-control" name="service"
                                                    id="" >
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label mt-2" for="form11Example1">Contact</label>
                                                <input value="{{ $department->contact }}" type="text"
                                                   class="form-control" name="contact"
                                                    id="" required>
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label mt-2" for="form11Example1">Location</label>
                                                <input value="{{ $department->location }}" type="text"
                                                    placeholder="Enter sector" class="form-control" name="location"
                                                    id="" required>
                                            </div>

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
