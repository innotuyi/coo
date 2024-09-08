<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{

    public function loan()
    {
        $leaves = Leave::all();
        $departments = Member::all();
        $leaveTypes = LeaveType::all();
        return view('admin.pages.Leave.leaveForm', compact('leaves', 'leaveTypes', 'departments'));
    }
    public function LoanList()
    {

        $leaves  =  User::select(
            'loans.*',                // Select all columns from the 'shares' table
            'm.id as member_id',        // Select and alias the 'id' column from the alias 'm'
            'm.name as member_name',    // Alias 'name' from the alias 'm'
            'm.phone as member_phone',  // Alias 'phone' from the alias 'm'
            'm.idcard as member_idcard',
            'm.district as member_district',
            'm.sector as member_sector'
        )
            ->join('loans', 'loans.userID', '=', 'm.id')  // Join the 'shares' table on 'userID'
            ->from('users as m') // Set alias for the 'users' table as 'm'
            // ->distinct() // Ensure distinct records are returned
            ->get();





        // $leaves = Loan::all();
        return view('admin.pages.Leave.leaveList', compact('leaves'));
    }

    public function paymentHistory() {

        // Fetch payment history information
    $payments = DB::table('payments as p')
    ->join('loans as l', 'p.loan_id', '=', 'l.id')
    ->join('users as u', 'l.userID', '=', 'u.id')
    ->select(
        'p.id as payment_id',
        'p.amount as payment_amount',
        'p.payment_date',
        'p.proof_of_payment',
        'l.id as loan_id',
        'l.amount as loan_amount',
        'l.interest_rate',
        'l.start_date',
        'l.end_date',
        'l.status as loan_status',
        'u.id as user_id',
        'u.name as user_name',
        'u.email as user_email'
    )
    ->orderBy('p.payment_date', 'desc')
    ->get();

// Return the results to a view or as JSON




        return view('admin.pages.Leave.paymentHistory', compact('payments'));
    }

    public function updateRemainingBalance($loanId, $paymentAmount) {
        // Fetch loan details
        $loan = DB::table('loans')->where('id', $loanId)->first();
        
        if (!$loan) {
            return null; // Handle loan not found
        }
        
        // Fetch payments and calculate the total amount paid
        $totalPaid = DB::table('payments')
                        ->where('loan_id', $loanId)
                        ->sum('amount');
    
        $remainingBalance = $loan->amount + ($loan->amount * ($loan->interest_rate / 100)) - $totalPaid;
        
        // Return the remaining balance
        return $remainingBalance;
    }
    

    function calculateMonthlyPayment($amount, $interestRate, $months) {
        $monthlyRate = $interestRate / 100 / 12;
        return ($amount * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$months));
    }
    
    function getLoanDetails($loanId) {
        $userId = auth()->user()->id; // Get the logged-in user's ID
    
        // Fetch loan details for the logged-in user with a JOIN on the users table
        $loan = DB::table('loans')
            ->join('users', 'loans.userID', '=', 'users.id')
            ->where('loans.id', $loanId)
            ->where('users.id', $userId) // Ensure the loan belongs to the logged-in user
            ->select('loans.*', 'users.name as user_name', 'users.email as user_email')
            ->first();
    
        if (!$loan) {
            return null; // Handle the case where no loan is found
        }
    
        $now = now();
        $endDate = new DateTime($loan->end_date);
        $diff = $endDate->diff($now);
        $overdueMonths = $diff->y * 12 + $diff->m;
    
        // Determine interest rate based on deadline
        $interestRate = $overdueMonths > 0 ? 15 : 5;
        $months = 8; // Fixed period for calculation
    
        // Use $this-> to reference the calculateMonthlyPayment method
        $monthlyPayment = $this->calculateMonthlyPayment($loan->amount, $interestRate, $months);
    
        // Update remaining balance
        $remainingBalance = $this->updateRemainingBalance($loanId, 0); // 0 as no payment in this context
    
        return view('admin.pages.Leave.myleaveDetails', [
            'loan_amount' => $loan->amount,
            'monthly_payment' => $monthlyPayment,
            'interest_rate' => $interestRate,
            'remaining_balance' => $remainingBalance,
            'user_name' => $loan->user_name,
            'user_email' => $loan->user_email,
            'loan_start_date' => $loan->start_date,
            'loan_end_date' => $loan->end_date,
            'loan_status' => $loan->status,
            'loanID' => $loanId,
        ]);
    }
    


    public function payment(Request $request, int $id) {
        try {
            // Validate the input
            $validate = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:0',
                'payment_date' => 'required|date',
                'proof_of_payment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Accept image or PDF
            ]);
    
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validate->errors(),
                ], 422); // Unprocessable Entity status code
            }
    
            // Handle file upload (if a file was uploaded)
            $fileName = null;
            if ($request->hasFile('proof_of_payment')) {
                $file = $request->file('proof_of_payment');
                $fileName = date('Ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads', $fileName, 'public');
            }
    
            // Insert the payment record using raw SQL
            DB::insert('
                INSERT INTO payments (loan_id, amount, payment_date, proof_of_payment, created_at, updated_at)
                VALUES (?, ?, ?, ?, NOW(), NOW())', [
                $id,
                $request->amount,
                $request->payment_date,
                $fileName, // Save the path of the uploaded file
            ]);
    
            // Update remaining balance
            $remainingBalance = $this->updateRemainingBalance($id, $request->amount);
            
            // Return success response
            return redirect()->back()->with('success', 'Payment recorded successfully. Remaining balance: ' . $remainingBalance);
    
        } catch (\Exception $e) {
            // Catching exceptions and returning an error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the payment.',
                'error' => $e->getMessage(),
            ], 500); // Internal Server Error status code
        }
    }
    
    
    

    public function myLeave()
    {

        // $userId = auth()->id(); // Or auth()->user()->id


        // $leaves = Loan::where('userID', $userId)->get();



        // return view('admin.pages.Leave.myLeave', compact('leaves'));


        // Corrected method to retrieve the authenticated user's ID
        $userId = auth()->user()->id;

        // Raw SQL query with a JOIN between users and loans
        $leaves = DB::select("
    SELECT loans.id, users.name, users.email, loans.amount, loans.interest_rate, loans.start_date, loans.end_date, loans.status
    FROM users
    INNER JOIN loans ON users.id = loans.userID
    WHERE users.id = ?
", [$userId]);


        // Pass the results to the view
        return view('admin.pages.Leave.myLeave', compact('leaves'));
    }

    // public function store(Request $request)
    // {
    //     $validate = Validator::make($request->all(), [
    //         'from_date' => 'required|date',
    //         'to_date' => 'required|date|after_or_equal:from_date',
    //         'leave_type_id' => 'required',
    //         'description' => 'required',
    //     ]);

    //     if ($validate->fails()) {
    //         notify()->error($validate->getMessageBag());
    //         return redirect()->back();
    //     }

    //     $fromDate = Carbon::parse($request->from_date);
    //     $toDate = Carbon::parse($request->to_date);
    //     $totalDays = $toDate->diffInDays($fromDate) + 1; // Calculate total days

    //     // Fetch the total days for the selected leave type ('leave_days' column)
    //     $leaveType = LeaveType::findOrFail($request->leave_type_id);
    //     $leaveTypeTotalDays = $leaveType->leave_days; // Assuming 'leave_days' is the field in the LeaveType model

    //     // Validate if the total days taken for this leave type don't exceed the available days
    //     $userId = auth()->user()->id;
    //     $totalTakenDaysForLeaveType = Leave::where('employee_id', $userId)
    //         ->where('leave_type_id', $request->leave_type_id)
    //         ->whereYear('from_date', '=', date('Y'))
    //         ->sum('total_days');

    //     $availableLeaveDays = $leaveTypeTotalDays - $totalTakenDaysForLeaveType;

    //     if ($totalDays > $availableLeaveDays) {
    //         notify()->error('Exceeded available leave days for this type.');
    //         return redirect()->back();
    //     }

    //     Leave::create([
    //         'employee_name' => auth()->user()->name,
    //         'employee_id' => auth()->user()->id,
    //         'department_name' => auth()->user()->employee->department->department_name,
    //         'designation_name' => auth()->user()->employee->designation->designation_name,
    //         'from_date' => $fromDate,
    //         'to_date' => $toDate,
    //         'total_days' => $totalDays,
    //         'leave_type_id' => $request->leave_type_id,
    //         'description' => $request->description,
    //     ]);

    //     notify()->success('New Leave created');
    //     return redirect()->back();
    // }



    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'leave_type_id' => 'required',
            'description' => 'required',
        ]);

        if ($validate->fails()) {
            notify()->error($validate->getMessageBag());
            return redirect()->back();
        }

        // Ensure 'from_date' is not in the past
        $today = Carbon::today();
        $fromDate = Carbon::parse($request->from_date);

        if ($fromDate->lessThanOrEqualTo($today)) {
            notify()->error('Leave start date should be a future date.');
            return redirect()->back();
        }


        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);
        $totalDays = $toDate->diffInDays($fromDate) + 1; // Calculate total days

        $leaveType = LeaveType::findOrFail($request->leave_type_id);
        $leaveTypeTotalDays = $leaveType->leave_days;

        $userId = 1;

        $totalTakenDaysForLeaveType = Leave::where('employee_id', $userId)
            ->where('leave_type_id', $request->leave_type_id)
            ->where('status', 'approved')
            ->sum('total_days');

        if (($totalTakenDaysForLeaveType + $totalDays) > $leaveTypeTotalDays) {
            notify()->error('Exceeds available leave days for this type.');
            return redirect()->back();
        }


        // Check if this is the first leave for the employee
        $firstLeave = Leave::where('employee_id', $userId)->count() === 0;

        if (!$firstLeave) {
            // Check if the employee's first leave is rejected or approved by the admin
            $firstLeaveStatus = Leave::where('employee_id', $userId)
                ->where('status', '!=', 'pending') // Exclude pending status (includes rejected and approved)
                ->orderBy('created_at', 'asc')
                ->value('status');

            if ($firstLeaveStatus === 'rejected') {
                // Allow reapplication if the first leave was rejected
                $firstLeaveStatus = 'approved';
            }

            if ($firstLeaveStatus !== 'approved') {
                notify()->error('You cannot take leave until your first leave is approved by the admin.');
                return redirect()->back();
            }
        }

        // Check if the previous leave's end date has passed
        $previousLeaveEndDate = Leave::where('employee_id', $userId)
            ->where('status', 'approved')
            ->orderBy('to_date', 'desc')
            ->value('to_date');

        if ($previousLeaveEndDate && Carbon::parse($previousLeaveEndDate)->isFuture()) {
            notify()->error('You cannot take leave until your previous leave date is over.');
            return redirect()->back();
        }

        Leave::create([
            // 'employee_name' => auth()->user()->name,
            'employee_name' => "innocent",
            // 'department_name' => optional(auth()->user()->employee->department)->department_name ?? 'Not specified',
            // 'designation_name' => optional(auth()->user()->employee->designation)->designation_name ?? 'Not specified',
            'department_name' => 'ICT',
            'designation_name' => 'IT HELP DESK',
            'employee_id' => $userId,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'total_days' => $totalDays,
            'leave_type_id' => $request->leave_type_id,
            'description' => $request->description,
        ]);

        notify()->success('New Leave created');
        return redirect()->back();
    }



    // Approve and Reject Leave
    public function approveLeave($id)
    {
        $leave = Loan::find($id);
        $leave->status = 1; // Assuming 'status' is a field in your 'leaves' table
        $leave->save();

        // notify()->success('Leave approved');
        return redirect()->back();
    }

    public function rejectLeave($id)
    {
        $leave = Leave::find($id);
        $leave->status = 'rejected'; // Assuming 'status' is a field in your 'leaves' table
        $leave->save();

        notify()->error('Leave rejected');
        return redirect()->back();
    }

    // Leave Type
    public function leaveType()
    {
        $leaveTypes = LeaveType::all();
        return view('admin.pages.leaveType.formList', compact('leaveTypes'));
    }

    public function leaveStore(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'leave_type_id' => 'required|string',
            'leave_days' => 'required|integer|min:0',
        ]);

        if ($validate->fails()) {
            notify()->error($validate->errors()->first()); // Retrieving the first validation error message
            return redirect()->back();
        }

        LeaveType::create([
            'leave_type_id' => $request->leave_type_id,
            'leave_days' => $request->leave_days,
        ]);

        // notify()->success('New Leave Type created successfully.');
        return redirect()->back();
    }

    // edit, delete, update LeaveType


    public function LeaveDelete($id)
    {
        $leaveType = LeaveType::find($id);
        if ($leaveType) {
            $leaveType->delete();
        }
        // notify()->success('Deleted Successfully.');
        return redirect()->back();
    }
    public function leaveEdit($id)
    {
        $leaveType = LeaveType::find($id);
        return view('admin.pages.leaveType.editList', compact('leaveType'));
    }
    public function LeaveUpdate(Request $request, $id)
    {
        $leaveType = LeaveType::find($id);
        if ($leaveType) {

            $leaveType->update([
                'leave_type_id' => $request->leave_type_id,
                'leave_days' => $request->leave_days,
            ]);

            notify()->success('Your information updated successfully.');
            return redirect()->route('leave.leaveType');
        }
    }

    // single employee report
    public function allLeaveReport()
    {
        $leaves = Leave::where('status', 'approved')
            ->with(['type'])
            ->paginate(5);

        return view('admin.pages.Leave.allLeaveReport', compact('leaves'));
    }




    // search leaveList
    public function searchLeaveList(Request $request)
    {
        $searchTerm = $request->search;

        $query = Leave::with(['type']);

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('employee_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('type', function ($typeQuery) use ($searchTerm) {
                        $typeQuery->where('leave_type_id', 'LIKE', '%' . $searchTerm . '%');
                    })
                    ->orWhere('from_date', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('to_date', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('total_days', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('department_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('designation_name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $leaves = $query->paginate(5);

        return view('admin.pages.Leave.searchLeaveList', compact('leaves'));
    }
}
