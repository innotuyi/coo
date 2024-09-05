@extends('admin.master')

@section('content')
<div class="page-header text-center">
    <span id="dayOfWeek" class="page-heading" style="font-size: 30px; font-weight: bold; color: #2c3e50;"></span><br>
    <span id='ct7' class="page-heading" style="font-size: 25px; color: #34495e;"></span>
    <p class="fw-medium fs-5 animated-text" style="color: #7f8c8d;">
        <span>Hello,</span>
        <span class="fw-bold" style="color: #3498db;">{{ auth()->user()->name }}</span>
        <span>Welcome to</span> 
        <span style="color: #e74c3c;">COTAVOGA MANAGEMENT SYSTEM</span>
        <span>👋</span>
    </p>
    <hr>
</div>
@if (auth()->user()->role === 'admin')
<section class="mb-3 mb-lg-5">
    <div class="row mb-3">
        @php
            $cards = [
                ['count' => $members, 'label' => 'Total Members', 'color' => 'red', 'image' => 'teamwork.png', 'route' => 'organization.member'],
                ['count' => $shares, 'label' => 'Total Shares', 'color' => 'dark', 'image' => 'task.png', 'route' => 'organization.share'],
                ['count' => $properties, 'label' => 'Total Property', 'color' => 'primary', 'image' => 'department.png', 'route' => 'organization.properties'],
                ['count' => $loans, 'label' => 'Loan Request', 'color' => 'warning', 'image' => 'leave.png', 'route' => 'loan.loanStatus'],
                ['count' => $agents, 'label' => 'Agents', 'color' => 'info', 'image' => 'users.png', 'route' => 'organization.agent'],
                ['count' => $punishments, 'label' => 'Punishments', 'color' => 'green', 'image' => 'money.png', 'route' => 'organization.punishment'],
                ['count' => $meetings, 'label' => 'All Meetings', 'color' => 'primary', 'image' => 'exchange.png', 'route' => 'organization.meeting'],
                ['count' => $expenditures, 'label' => 'All Expenditures', 'color' => 'dark', 'image' => 'logout.png', 'route' => 'organization.expenduture'],
            ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold text-{{ $card['color'] }}" style="font-size: 28px;">{{ $card['count'] }}</h4>
                            <p class="text-muted mb-0">{{ $card['label'] }}</p>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <img class="img-fluid" style="width: 40px;" src="{{ asset('assests/image/' . $card['image']) }}" alt="">
                        </div>
                    </div>
                </div>
                <a class="text-decoration-none" href="{{ route($card['route']) }}">
                    <div class="card-footer py-3 bg-{{ $card['color'] }}-light text-{{ $card['color'] }} text-center" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                        <p class="mb-0">View Details <i class="fas fa-arrow-right ms-2"></i></p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
@endsection
