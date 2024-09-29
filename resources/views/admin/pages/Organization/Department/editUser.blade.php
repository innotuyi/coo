@extends('admin.master')

@section('content')
    <div class="shadow p-4 d-flex justify-content-between align-items-center ">
        <h4 class="text-uppercase">Edit Guardian</h4>
    </div>
    <div class="container my-5 py-5">

        <!--Section: Form Design Block-->
        <section>
            <div class="d-flex gap-5 justify-content-center align-content-center ">

                {{-- Department Form start --}}
                <div class="text-left w-50 ">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="text-uppercase">Update Guardian</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update', $department->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="name">Names</label>
                                            <input value="{{ old('name', $department->name) }}" placeholder="Enter Name" class="form-control" name="name" id="name">
                                        </div>
                        
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="email">Email</label>
                                            <input value="{{ old('email', $department->email) }}" placeholder="" class="form-control" name="email" id="email">
                                        </div>
                        
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password">
                                        </div>
                        
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="idcard">National ID</label>
                                            <input value="{{ old('idcard', $department->idcard) }}" type="number" placeholder="Enter 16 DIGIT" class="form-control" name="idcard" id="idcard">
                                        </div>
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="phone">Phone Number</label>
                                            <input value="{{ old('phone', $department->phone) }}" type="number" placeholder="Enter phone" class="form-control" name="phone" id="phone">
                                        </div>
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="district">District</label>
                                            <input value="{{ old('district', $department->district) }}" type="text" placeholder="Enter district" class="form-control" name="district" id="district">
                                        </div>
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="sector">Sector</label>
                                            <input value="{{ old('sector', $department->sector) }}" type="text" placeholder="Enter sector" class="form-control" name="sector" id="sector">
                                        </div>
                        
                                        <!-- Image (optional) -->
                                        <div class="mb-3">
                                            <label for="user_image" class="form-label">Profile Image (optional)</label>
                                            <input type="file" class="form-control" name="user_image" id="user_image">
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
