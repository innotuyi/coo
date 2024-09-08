@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center">
    <h4 class="text-uppercase">Account Status</h4>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
        Add Account
    </button>
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
    <!--Section: Table Block-->
    <section>

        <!-- Cooperative Accounts Table -->
        <div class="w-100 card">
            <div class="card-body">
                <table class="table align-middle mb-4 text-center bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>NO</th>
                            <th>Type</th>
                            <th>Account Number</th>
                            <th>Account Holder Name</th>
                            <th>Balance</th>
                            {{-- <th>Interest Rate</th> --}}
                            <th>Opening Date</th>
                            {{-- <th>Punishment Date</th> --}}
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->account_number }}</td>
                            <td>{{ $item->account_holder_name }}</td>
                            <td>{{ $item->balance }}</td>
                            {{-- <td>{{ $item->interest_rate }}</td> --}}
                            <td>{{ \Carbon\Carbon::parse($item->opening_date)->format('d M Y') }}</td>
                            {{-- <td>{{ $item->punishimentDate ? \Carbon\Carbon::parse($item->punishimentDate)->format('d M Y') : 'N/A' }}</td> --}}
                            {{-- <td>
                                <a class="btn btn-success rounded-pill fw-bold text-white"
                                    href="{{ route('cooperative.edit', $item->id) }}">Edit</a>
                                <a class="btn btn-danger rounded-pill fw-bold text-white"
                                    href="{{ route('cooperative.delete', $item->id) }}">Delete</a>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<!-- Add Account Modal -->
<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAccountModalLabel">Add Cooperative Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cooperative.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" name="type" placeholder="Enter Account Type">
                    </div>
                    <div class="mb-3">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" class="form-control" name="account_number" placeholder="Enter Account Number" required>
                    </div>
                    <div class="mb-3">
                        <label for="account_holder_name" class="form-label">Account Holder Name</label>
                        <input type="text" class="form-control" name="account_holder_name" placeholder="Enter Account Holder Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="balance" class="form-label">Balance</label>
                        <input type="number" step="0.01" class="form-control" name="balance" placeholder="Enter Balance" required>
                    </div>
                    <div class="mb-3">
                        <label for="interest_rate" class="form-label">Interest Rate</label>
                        <input type="number" step="0.01" class="form-control" name="interest_rate" placeholder="Enter Interest Rate" required>
                    </div>
                    <div class="mb-3">
                        <label for="opening_date" class="form-label">Opening Date</label>
                        <input type="date" class="form-control" name="opening_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="punishimentDate" class="form-label">Punishment Date (optional)</label>
                        <input type="date" class="form-control" name="punishimentDate">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Create</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
