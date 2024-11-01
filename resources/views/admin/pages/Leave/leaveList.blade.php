@extends('admin.master')

@section('content')
<div class="shadow p-4 d-flex justify-content-between align-items-center">
    <h4 class="text-uppercase">Loan Request Status</h4>
</div>
<div class="my-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="input-group rounded w-50"></div>
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!--@foreach ($leaves as $leave)-->
            <!--<tr>-->
            <!--    <td>{{ $leave->id }}</td>-->
            @foreach ($leaves  as $key =>  $leave)
                            <tr>
                                <td class="text-wrap">{{ $key + 1 }}</td>
                <td>{{ $leave->member_name }}</td>
                <td>{{ $leave->amount }}</td>
                <td>{{ $leave->interest_rate }}%</td>
                <td>{{ $leave->start_date }}</td>
                <td>{{ $leave->end_date }}</td>
                <td>{{ $leave->status }}</td>
                <td>
                    @if ($leave->status == 'approved')
                    <span class="text-white fw-bold bg-green rounded-pill p-2">Approved</span>
                    @elseif ($leave->status == 'rejected')
                    <span class="text-white fw-bold bg-red rounded-pill p-2">Rejected</span>
                    @else
                    <a class="btn btn-success rounded-pill "
                        href="{{ route('leave.approve', ['id' => $leave->id]) }}">Approve</a>

                    <!-- Reject button triggers modal -->
                    <button class="btn btn-danger rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#rejectModal{{ $leave->id }}">Reject</button>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Reject Loan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('leave.reject', ['id' => $leave->id]) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="comment" class="form-label">Rejection Comment</label>
                                            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Reject Loan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
