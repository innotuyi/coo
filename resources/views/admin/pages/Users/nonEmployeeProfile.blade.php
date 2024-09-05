@extends('admin.master')
@section('content')

<div class="shadow p-4 d-flex justify-content-between align-items-center ">
    <h4 class="text-uppercase">My Profile</h4>
</div>

<section>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img alt="User Image" src="{{ url('/uploads//' . $user->user_image) }}"
                            class="rounded-circle mx-auto img-fluid"
                            style="width: 150px; height: 150px; object-fit: cover;">
                        <h5 class="my-3">{{ $user->name }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $user->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Role</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $user->role }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loan Details Section -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">My Loans</h5>
                    </div>
                    <div class="card-body">
                        @if($loans->isEmpty())
                            <p class="text-muted mb-0">You have no loans.</p>
                        @else
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Loan ID</th>
                                        <th>Amount</th>
                                        <th>Interest Rate</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loans as $loan)
                                        <tr>
                                            <td>{{ $loan->id }}</td>
                                            <td>{{ $loan->amount }}</td>
                                            <td>{{ $loan->interest_rate ?? 'N/A' }}</td>
                                            <td>{{ $loan->start_date }}</td>
                                            <td>{{ $loan->end_date }}</td>
                                            <td>
                                                @if($loan->status == 0)
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($loan->status == 1)
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <!-- Share Details Section -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">My Shares</h5>
                    </div>
                    <div class="card-body">
                        @if($shares->isEmpty())
                            <p class="text-muted mb-0">You have no shares.</p>
                        @else
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Share ID</th>
                                        <th>Amount</th>
                                        <th>Joining Date</th>
                                        <th>Amount Increase</th>
                                        <th>Interest Rate</th>
                                        <th>Total Share</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shares as $share)
                                        <tr>
                                            <td>{{ $share->id }}</td>
                                            <td>{{ $share->amount ?? 'N/A' }}</td>
                                            <td>{{ $share->joining_date ?? 'N/A' }}</td>
                                            <td>{{ $share->amount_increase ?? 'N/A' }}</td>
                                            <td>{{ $share->interest_rate ?? 'N/A' }}</td>
                                            <td>{{ $share->total_share ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
