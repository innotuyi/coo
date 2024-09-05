@extends('admin.master')
@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center ">
    <h4 class="text-uppercase">Apply Loan</h4>
    {{-- <div>
        <a href="{{ route('leave.myLeave') }}" class="btn btn-success p-2 px-3 text-lg rounded-pill me-3">Leave
            Status</a>
        <a href="{{ route('leave.myLeaveBalance') }}" class="btn btn-success p-2 px-3 text-lg rounded-pill">Leave
            Balance</a>
    </div> --}}
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
                        <form action="{{ route('leave.store') }}" method="post">
                            @csrf
                            <div class="row mb-4">
                                <div class="row mb-4">
                                    <!-- From Date Field -->
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <label class="form-label mt-2 fw-bold" for="start_date">From Date</label>
                                            <input required placeholder="Select" type="date" id="start_date" name="start_date" class="form-control" />
                                        </div>
                                        <div class="mt-2">
                                            @error('start_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                        
                                    <!-- To Date Field -->
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <label class="form-label mt-2 fw-bold" for="end_date">To Date</label>
                                            <input required placeholder="Select" type="date" id="end_date" name="end_date" class="form-control" />
                                        </div>
                                        <div class="mt-2">
                                            @error('end_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                        
                                    <!-- Amount Field -->
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <label class="form-label mt-2 fw-bold" for="amount">Amount</label>
                                            <input  placeholder="" type="number" id="amount" name="amount" class="form-control" />
                                        </div>
                                        <div class="mt-2">
                                            @error('amount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                        
                                    <!-- Guardian Dropdown -->
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="guardID">Member</label>
                                            <select class="form-control" name="userID">
                                                @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Loan Approval Status (Radio Buttons) -->
                                {{-- <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold mt-2">Loan Approval Status</label>
                                        <div>
                                            <input type="radio" id="approved" name="status" value="1" >
                                            <label for="approved">Approved</label>
                        
                                            <input type="radio" id="not_approved" name="status" value="0">
                                            <label for="not_approved">Not Approved</label>
                                        </div>
                                        <div class="mt-2">
                                            @error('loan_status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <label class="form-label mt-2" for="guardID">Interest Rate</label>
                                            <input required  type="number" id="interest_rate" name="interest_rate" class="form-control" />

                                        </div>
                                    </div>
                                </div> --}}
                        
                                <!-- Submit Button -->
                                <div class="text-center w-25 mx-auto mt-3">
                                    <button type="submit" class="btn btn-success p-2 text-lg rounded-pill col-md-10">Submit</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection