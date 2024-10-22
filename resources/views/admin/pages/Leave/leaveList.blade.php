@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center">
    <h4 class="text-uppercase">Loan Request Status</h4>
</div>
<div class="my-5 py-5">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="input-group rounded w-50">
            <form action="{{ route('searchLeaveList') }}" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." name="search">
                    <button type="submit" class="input-group-text border-0 bg-transparent" id="search-addon">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <a href="allLeaveReport" class="btn btn-danger text-capitalize border-0" data-mdb-ripple-color="dark"><i
                class="fa-regular fa-paste me-1"></i>Report</a>
    </div>

    <table class="table align-middle text-center w-100 bg-white">
        <thead class="bg-light">
            <tr>
                <th>N/0</th>
                <th>Member</th>
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
                <td>{{ $leave->id }}</td>
                <td>{{ $leave->member_name }}</td>
                <td>{{ $leave->amount }}</td>
                <td>{{ $leave->interest_rate }}</td>
                <td>{{ $leave->start_date }}</td>
                <td>{{ $leave->end_date }}</td>
                <td>{{ $leave->status }}</td>




            


                    <td>
                        @if ($leave->status === '1')
                        <span class="text-white fw-bold bg-green rounded-pill p-2">Accepted</span>
                        @elseif ($leave->status === '0')
                        <span class="text-white fw-bold bg-red rounded-pill p-2">Rejected</span>
                        @else
                        <span class="text-white fw-bold bg-warning rounded-pill p-2">Pending</span>
                        @endif
                    @else
                    <a class="btn btn-success rounded-pill "
                        href="{{ route('leave.approve', ['id' => $leave->id]) }}">Approve</a>
                    <a class="btn btn-danger rounded-pill "
                        href="{{ route('leave.reject', ['id' => $leave->id]) }}">Reject</a>
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
   
</div>
@endsection