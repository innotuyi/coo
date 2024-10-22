@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center">
    <h4 class="text-uppercase">My Loan</h4>
    <div>
        <a href="{{ route('loan.loanForm') }}" class="btn btn-success p-2 px-3 text-lg rounded-pill">Apply Loan</a>
    </div>
</div>

<div class="container my-5 py-5">
    <table class="table align-middle text-center table-hover bg-white">
        <thead class="bg-light">
            <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Interest Rate</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaves as $leave)
            <tr>
                <td>{{ $leave->name }}</td>
                <td>{{ $leave->amount }}</td>
                <td>{{ $leave->interest_rate }}</td>
                <td>{{ $leave->start_date }}</td>
                <td>{{ $leave->end_date }}</td>

                <!-- Status Column -->
                <td>
                    @if ($leave->status === '1')
                    <span class="text-white fw-bold bg-green rounded-pill p-2">Accepted</span>
                    @elseif ($leave->status === '0')
                    <span class="text-white fw-bold bg-red rounded-pill p-2">Rejected</span>
                    @else
                    <span class="text-white fw-bold bg-warning rounded-pill p-2">Pending</span>
                    @endif
                </td>

                <!-- Comment Column: Display comment only when status is rejected -->
                <td>
                    @if ($leave->status === '0')
                    {{ $leave->comment }}
                    @else
                    <!-- No comment shown if not rejected -->
                    -
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
