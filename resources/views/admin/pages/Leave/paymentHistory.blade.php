@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center">
    <h4 class="text-uppercase">Payment History</h4>
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

    <table class="table table-striped">
        <thead>
            <tr>
                {{-- <th>Payment ID</th>
                <th>Loan ID</th>
                <th>User ID</th> --}}
                <th>Name</th>
                <th>Email</th>
                <th>Payment Amount</th>
                <th>Payment Date</th>
                <th>Proof</th>
                <th>Loan Amount</th>
                {{-- <th>Interest Rate</th> --}}
                <th>Start Date</th>
                <th>End Date</th>
                <th>Loan Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                {{-- <td>{{ $payment->payment_id }}</td>
                <td>{{ $payment->loan_id }}</td>
                <td>{{ $payment->user_id }}</td> --}}
                <td>{{ $payment->user_name }}</td>
                <td>{{ $payment->user_email }}</td>
                <td>{{ number_format($payment->payment_amount, 2) }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>
                    @if($payment->proof_of_payment)
                        <a href="{{ url('storage/uploads/' . $payment->proof_of_payment) }}" target="_blank">View Proof</a>
                    @else
                        No Proof
                    @endif
                </td>
                <td>{{ number_format($payment->loan_amount, 2) }}</td>
                {{-- <td>{{ $payment->interest_rate }}%</td> --}}
                <td>{{ $payment->start_date }}</td>
                <td>{{ $payment->end_date }}</td>
                <td>{{ $payment->loan_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
   
</div>
@endsection