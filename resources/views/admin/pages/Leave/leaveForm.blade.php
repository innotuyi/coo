@extends('admin.master')
@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center ">
    <h4 class="text-uppercase">Apply Loan</h4>
</div>
<div class="container my-5 py-5">
    <!--Section: Form Design Block-->
    <section>
        <div>
            <div class="w-75 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0 text-font text-uppercase">Loan Form</h5>
                    </div>
                    <div class="card-body">

                        <!-- Flash Message Display -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('leave.store') }}" method="post">
                            @csrf
                            <div class="row mb-4">
                                <!-- Loan Amount Field -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <label class="form-label mt-2 fw-bold" for="amount">Loan Amount</label>
                                        <input required placeholder="Enter loan amount" type="number" id="amount" name="amount" class="form-control" min="1" max="700000" />
                                    </div>
                                    <div class="mt-2">
                                        @error('amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        
                                <!-- Start Date Field -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <label class="form-label mt-2 fw-bold" for="start_date">Start Date</label>
                                        <input required placeholder="Select start date" type="date" id="start_date" name="start_date" class="form-control" />
                                    </div>
                                    <div class="mt-2">
                                        @error('start_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        
                                <!-- End Date Field -->
                                <div class="col-md-12">
                                    <div class="form-outline">
                                        <label class="form-label mt-2 fw-bold" for="end_date">End Date</label>
                                        <input required placeholder="Select end date" type="date" id="end_date" name="end_date" class="form-control" />
                                    </div>
                                    <div class="mt-2">
                                        @error('end_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        
                                <!-- Conditional Member Dropdown (Visible for accountants) -->
                                @if ($isAccountant)
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <label class="form-label mt-2 fw-bold" for="userID">Member</label>
                                        <select class="form-control" id="userID" name="userID">
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @else
                                <!-- Member Applying for Themselves (Hidden input for members) -->
                                <input type="hidden" id="userID" name="userID" value="{{ auth()->user()->id }}">
                                @endif
                            </div>
                        
                            <!-- Submit Button -->
                            <div class="text-center w-25 mx-auto mt-3">
                                <button type="submit" class="btn btn-success p-2 text-lg rounded-pill col-md-10">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
