@extends('admin.master')

@section('content')
    <div class="shadow p-4 d-flex justify-content-between align-items-center ">
        <h4 class="text-uppercase">My Loan</h4>
        <div>
            <a href="{{ route('loan.loanForm') }}" class="btn btn-success p-2  px-3 text-lg rounded-pill">Apply Loan</a>
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

        <table class="table align-middle text-center table-hover bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Interest Rate</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $user_name }}</td>
                    <td>{{ $loan_amount }}</td>
                    <td>{{ $interest_rate }}%</td>
                    <td>{{ $loan_start_date }}</td>
                    <td>{{ $loan_end_date }}</td>
                    <td>
                        @if ($loan_status === '1')
                            <span class="text-white fw-bold bg-green rounded-pill p-2">Accepted</span>
                        @elseif($loan_status === '0')
                            <span class="text-white fw-bold bg-warning rounded-pill p-2">Pending</span>
                        @else
                            <span class="text-white fw-bold bg-warning rounded-pill p-2">Pending</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="loan-info-section mt-4 p-4 bg-light rounded shadow-sm">
            <h4 class="loan-info-title mb-3 text-primary">Additional Loan Information</h4>

            <div class="loan-info-details row">
                <div class="col-md-4">
                    <div class="info-item mb-3">
                        <span class="info-label">Monthly Payment:</span>
                        <span class="info-value fw-bold text-dark">{{ $monthly_payment }}</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-item mb-3">
                        <span class="info-label">Remaining Balance:</span>
                        <span class="info-value fw-bold text-dark">{{ $remaining_balance }}</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Payment Button -->
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                        data-bs-target="#paymentModal" @if ($remaining_balance <= 0) disabled @endif>
                        Make a Payment
                    </button>
                </div>

            </div>
        </div>


        <div class="w-25 mx-auto mt-4">
            {{-- {{ $leaves->links() }} --}}
        </div>
    </div>
    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Make a Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Check if there are any validation errors and display them -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('payment.store', $loanID) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <!-- Payment Amount Field -->
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <label class="form-label mt-2 fw-bold" for="amount">Payment Amount</label>
                                    <input required type="number" id="amount" name="amount" class="form-control"
                                        value="{{ old('amount') }}" />
                                    @error('amount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payment Date Field -->
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <label class="form-label mt-2 fw-bold" for="payment_date">Payment Date</label>
                                    <input required type="date" id="payment_date" name="payment_date"
                                        class="form-control" value="{{ old('payment_date') }}" />
                                    @error('payment_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Proof of Payment Field -->
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <label class="form-label mt-2 fw-bold" for="proof_of_payment">Proof of Payment
                                        (Screenshot/PDF)</label>
                                    <input type="file" id="proof_of_payment" name="proof_of_payment" class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf" />
                                    @error('proof_of_payment')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center w-25 mx-auto mt-3">
                                <button type="submit"
                                    class="btn btn-success p-2 text-lg rounded-pill col-md-10">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                paymentModal.show();
            });
        </script>
    @endif


    <style>
        .loan-info-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .loan-info-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #007bff;
        }

        .loan-info-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .info-item {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .info-label {
            font-size: 1rem;
            font-weight: 500;
            color: #6c757d;
            display: inline-block;
            width: 140px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #212529;
        }


        .modal .modal-dialog {
            max-width: 800px;
        }

        .modal .form-outline {
            margin-bottom: 20px;
        }

        .modal .btn-close {
            outline: none;
        }

        .modal .modal-header {
            border-bottom: none;
        }

        .modal .modal-body {
            padding-top: 0;
        }
    </style>
@endsection
