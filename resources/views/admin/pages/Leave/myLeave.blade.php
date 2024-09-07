@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center ">
    <h4 class="text-uppercase">My Loan</h4>
    <div>
        <a href="{{ route('loan.loanForm') }}" class="btn btn-success p-2  px-3 text-lg rounded-pill">Apply  Loan</a>
    </div>
</div>
<div class="container my-5 py-5">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="input-group rounded w-50">
            <form action="{{ route('searchMyLeave') }}" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." name="search">
                    <button type="submit" class="input-group-text border-0 bg-transparent" id="search-addon">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <a href="{{ route('myLeaveReport') }}" class="btn btn-danger text-capitalize border-0"
            data-mdb-ripple-color="dark"><i class="fa-regular fa-paste me-1"></i>Report</a>
    </div>


    <table class="table align-middle text-center table-hover  bg-white">
        <thead class="bg-light">
            <tr>
                <th>Member ID</th>
                <th>Amount</th>
                <th>Interest Rate</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaves as $leave)
            <tr>
                <td>{{ $leave->userID }}</td>
                <td>{{ $leave->amount }}</td>
                <td>{{ $leave->interest_rate }}</td>
                <td>{{ $leave->start_date }}</td>
                <td>{{ $leave->end_date }}</td>
                <td>{{ $leave->status }}</td>
                <td>
                    @if($leave->status === '1')
                    <span class="text-white fw-bold bg-green rounded-pill p-2">Accepted</span>
                    @elseif($leave->status === '0')
                    {{-- <span class="text-white fw-bold bg-red rounded-pill p-2">Rejected</span> --}}
                    <span class="text-white fw-bold bg-warning rounded-pill p-2">Pending</span>

                    @else
                    <span class="text-white fw-bold bg-warning rounded-pill p-2">Pending</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="w-25 mx-auto mt-4">
        {{-- {{ $leaves->links() }} --}}
    </div>
</div>
@endsection