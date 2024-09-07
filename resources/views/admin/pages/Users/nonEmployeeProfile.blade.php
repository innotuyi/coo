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
                            @if (file_exists(public_path('storage/uploads/' . $user->user_image)))
                                <img class="avatar rounded-circle" alt="db Avatar"
                                    src="{{ url('storage/uploads/' . $user->user_image) }}"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img class="avatar rounded-circle" alt="User Avatar"
                                    src="{{asset('assests/image/default.png') }}">
                            @endif

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

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Join Date</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->created_at }}</p>
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
                            @if ($loans->isEmpty())
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
                                        @foreach ($loans as $loan)
                                            <tr>
                                                <td>{{ $loan->id }}</td>
                                                <td>{{ $loan->amount }}</td>
                                                <td>{{ $loan->interest_rate ?? 'N/A' }}</td>
                                                <td>{{ $loan->start_date }}</td>
                                                <td>{{ $loan->end_date }}</td>
                                                <td>
                                                    @if ($loan->status == 0)
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
                            @if ($shares->isEmpty())
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
                                        @foreach ($shares as $share)
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

<!-- Profile Update Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (leave blank to keep current password)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="user_image" class="form-label">Profile Image (optional)</label>
                        <input type="file" class="form-control" id="user_image" name="user_image">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
