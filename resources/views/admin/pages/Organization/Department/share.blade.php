@extends('admin.master')

@section('content')
    <div class="shadow p-4 d-flex justify-content-between align-items-center ">
        <h4 class="text-uppercase">Share List</h4>
        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShareModal">
            Add Share
        </button>
    </div>
    <!-- Display success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif




    <div class="container my-5 py-5">
        <section>

            <div class="d-flex justify-content-end">
                <div class="input-group rounded w-25 mb-5">
                    <!--<form action="{{ route('searchDepartment') }}" method="get">-->
                    <!--    <div class="input-group">-->
                    <!--        <input type="text" class="form-control" placeholder="Search..." name="search">-->
                    <!--        <button type="submit" class="input-group-text border-0 bg-transparent" id="search-addon">-->
                    <!--            <i class="fas fa-search"></i>-->
                    <!--        </button>-->
                    <!--    </div>-->
                    <!--</form>-->
                </div>
            </div>

            <!-- Share Table start -->
            <div class="w-100 card">
                <div>
                    <table class="table align-middle mb-4 text-center bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>NO</th>
                                <th>Member Name</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Amount Increase</th>
                                {{-- <th>Interest Rate</th> --}}
                                <th>Total Share</th>
                                <th>Status</th>
                                <th>View Attachment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($shares->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">No shares available</td>
                                </tr>
                            @else
                                @foreach ($shares as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->member_name }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->joining_date }}</td>
                                        <td>{{ $item->amount_increase ?? 'N/A' }}</td>
                                        <td>{{ $item->total_share ?? 'N/A' }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if ($item->meeting_attachment)
                                                <a href="{{ url('storage/uploads/' . $item->attachment) }}"
                                                    target="_blank">View Attachment</a>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Conditionally enable/disable the 'Sell share' button -->
                                            <a class="btn btn-danger rounded-pill fw-bold text-white {{ $item->status === 'transferred' ? 'disabled' : '' }}"
                                                data-bs-toggle="{{ $item->status === 'transferred' ? '' : 'modal' }}"
                                                data-bs-target="{{ $item->status === 'transferred' ? '' : '#addTransferbtn' . $item->id }}">
                                                Sell share
                                            </a>
                                            <a class="btn btn-danger rounded-pill fw-bold text-white"
                                                href="{{ route('share.delete', $item->id) }}">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- Modal HTML -->
                                    @if ($item->status !== 'transferred')
                                        <div class="modal fade" id="addTransferbtn{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="addTransferLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addTransferLabel{{ $item->id }}">
                                                            Transfer Shares</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('shares.transfer', $item->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('put')

                                                            <div class="mb-3">
                                                                <label for="recipient_userID"
                                                                    class="form-label">Recipient</label>
                                                                <select class="form-control" id="recipient_userID"
                                                                    name="recipient_userID" required>
                                                                    @foreach ($departments as $user)
                                                                        <option value="{{ $user->id }}">
                                                                            {{ $user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="amount" class="form-label">Amount
                                                                    Charged</label>
                                                                <input type="number" class="form-control" id="amount"
                                                                    value="500" name="amount" min="0"
                                                                    step="any" required>
                                                            </div>
                                                            <div class="form-outline mt-3">
                                                                <label class="form-label"
                                                                    for="attachment">Attachment</label>
                                                                <input type="file" class="form-control"
                                                                    name="attachment">
                                                            </div>

                                                            <button type="submit" class="btn btn-primary">Transfer
                                                                Shares</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>


                    </table>
                </div>
            </div>

        </section>
    </div>

    <!-- Modal for adding a new share -->
    <div class="modal fade" id="addShareModal" tabindex="-1" aria-labelledby="addShareModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addShareModalLabel">Add Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('organization.shareStore') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <label class="form-label" for="userID">Member</label>
                                    <select class="form-control" name="userID">
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-outline mt-3">
                                    <label class="form-label" for="amount">Amount</label>
                                    <input type="number" class="form-control" name="amount" required>
                                </div>
                                <div class="form-outline mt-3">
                                    <label class="form-label" for="joining_date">Date</label>
                                    <input type="date" class="form-control" name="joining_date" required>
                                </div>
                                <div class="form-outline mt-3">
                                    <label class="form-label" for="amount_increase">Amount Increase</label>
                                    <input type="number" class="form-control" name="amount_increase">
                                </div>

                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
