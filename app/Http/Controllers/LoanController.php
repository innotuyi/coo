<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\loan;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        return view('admin.pages.Leave.leaveForm', compact('leaves', 'leaveTypes', 'departments'));
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
        $validate = Validator::make($request->all(), [
            'amount'=>'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:from_date',
            'interest_rate' => '|min:0',
            'userID' => 'required',

        ]);

      



        if ($validate->fails()) {
            notify()->error($validate->getMessageBag());
            return redirect()->back();
        }

        // Ensure 'from_date' is not in the past
        $today = Carbon::today();
        $fromDate = Carbon::parse($request->from_date);

        if ($fromDate->lessThanOrEqualTo($today)) {
            notify()->error('Loan start date should be a future date.');
            return redirect()->back();
        }

        $fromDate = Carbon::parse($request->start_date);
        $toDate = Carbon::parse($request->end_date);
        $totalDays = $toDate->diffInDays($fromDate) + 1; // Calculate total days

     
        loan::create([
            'start_date' =>$fromDate,
            'end_date' =>$toDate,
            'interest_rate' =>$request->interest_rate,
            'amount' =>$request->amount,
            'userID' =>$request->userID,
            'status' => "0", // Store the status (approved or not)
        ]);

        notify()->success('Applied Loan successfuly');
        return redirect()->back();
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
