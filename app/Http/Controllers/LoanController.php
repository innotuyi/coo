<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\loan;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function loan()
    {
        $leaves = Leave::all();
        $departments = User::all();
        $leaveTypes = LeaveType::all();
        $currentUser = auth()->user(); // Get the currently logged-in user
        $isAccountant = $currentUser->role === 'accountant'; // Check if current user is accountant
        return view('admin.pages.Leave.leaveForm', compact('leaves', 'leaveTypes', 'departments', 'currentUser', 'isAccountant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        // Validate the input
        $validate = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0|max:700000',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'userID' => 'required|exists:users,id',
        ]);
    
        if ($validate->fails()) {
            // Store validation error messages in the session
            return redirect()->back()->withErrors($validate)->withInput();
        }
    
        // Ensure 'start_date' is not in the past
        $today = Carbon::today();
        $fromDate = Carbon::parse($request->start_date);
        $toDate = Carbon::parse($request->end_date);
    
        if ($fromDate->lessThanOrEqualTo($today)) {
            // Flash error message
            return redirect()->back()->with('error', 'Loan start date should be a future date.');
        }
    
        // Calculate the number of months for the loan
        $months = $fromDate->diffInMonths($toDate);
    
        // Set fixed interest rates
        $interestRate = $months <= 8 ? 5 : 15;
    
        // Insert new loan record using raw SQL
        DB::insert('
            INSERT INTO loans (userID, amount, interest_rate, start_date, end_date, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $request->userID,
            $request->amount,
            $interestRate,
            $fromDate,
            $toDate,
            '0'
        ]);
    
        // Flash success message
        return redirect()->back()->with('success', 'Loan application submitted successfully.');
    }
    
    
    public function myLeave()
    {
        
        $leaves = Loan::all();
        return view('admin.pages.Leave.leaveList', compact('leaves'));
       
    }


    /**
     * Display the specified resource.
     */
    public function show(loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(loan $loan)
    {
        //
    }
}
