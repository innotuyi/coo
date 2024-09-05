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
use Illuminate\Http\Request;
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

        $leaves = Loan::all();
        return view('admin.pages.Leave.leaveList', compact('leaves'));
    }


    public function myLeave()
    {

        $userId = auth()->id(); // Or auth()->user()->id

        $leaves = Loan::where('userID', $userId)->get();
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
