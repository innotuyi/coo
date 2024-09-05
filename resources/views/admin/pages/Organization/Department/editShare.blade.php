@extends('admin.master')

@section('content')
    <div class="shadow p-4 d-flex justify-content-between align-items-center ">
        <h4 class="text-uppercase">Edit Share</h4>
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
                            <h5 class="text-uppercase">Update Share</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('share.shareUpdate', $department->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label" for="memberID">Member</label>
                                            <input value="{{ $department->member_name }}" class="form-control"
                                                name="{{ $department->memberID }}" required>

                                        </div>
                                        <div class="form-outline mt-3">
                                            <label class="form-label" for="amount">Amount</label>
                                            <input value="{{ $department->amount }}" type="number" class="form-control"
                                                name="amount">
                                        </div>
                                        <div class="form-outline mt-3">
                                            <label class="form-label" for="joining_date">Joining Date</label>
                                            <input value="{{ $department->joining_date }}" type="date"
                                                class="form-control" name="joining_date">
                                        </div>
                                        <div class="form-outline mt-3">
                                            <label class="form-label" for="amount_increase">Amount Increase</label>
                                            <input value="{{ $department->amount_increase }}" type="number"
                                                class="form-control" name="amount_increase">
                                        </div>
                                        <div class="form-outline mt-3">
                                            <label class="form-label" for="interest_rate">Interest Rate</label>
                                            <input value="{{ $department->interest_rate }}" type="number"
                                                class="form-control" name="interest_rate">
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
