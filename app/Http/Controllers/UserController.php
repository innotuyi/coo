<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\Share;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login()
    {
        return view('admin.pages.AdminLogin.adminLogin');
    }

    public function loginPost(Request $request)
    {
        $val = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]
        );

        if ($val->fails()) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($val)->withInput();
        }


        $credentials = $request->except('_token');

        $login = auth()->attempt($credentials);
        if ($login) {
            notify()->success('Successfully Logged in');
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors('Invalid user email or password');
    }

    public function logout()
    {
        auth()->logout();
        session()->flash('success', 'Successfully Logged Out');
        return redirect()->route('home');
    }

    public function list()
    {
        $users = User::all();
        // $employee = Employee::first(); // Fetches the first employee
        return view('admin.pages.Users.list', compact('users'));
    }

    public function createForm($employeeId)
    {
        // $employee = Employee::find($employeeId);

        // if (!$employee) {
        //     return redirect()->back()->withErrors('Employee not found');
        // }

        return view('admin.pages.Users.createForm', compact('employee'));
    }

    public function userProfile($id)
    {
        $user = User::find($id);
        // $employee = $user->employee ?? null;
        // $departments = Department::all();
        // $designations = Designation::all();
        return view('admin.pages.Users.userProfile', compact('user'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'guardID' => 'nullable|exists:guardians,id',
            'phone' => 'required|min:10|max:10',
            'idcard' => 'required|min:16|max:16',
            'district' => 'required|string',
            'sector' => 'required|string',
        ]);

        if ($validate->fails()) {
            // Notify the user and return validation errors back to the view
            notify()->error('Invalid Credentials.');

            // Redirect back with input and error messages
            return redirect()->back()
                ->withErrors($validate)
                ->withInput(); // This retains the input data so the user doesn’t have to retype everything
        }


        $fileName = null;
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $fileName = date('Ymdhis') . '.' . $file->getClientOriginalExtension();

            $file->storeAs('/uploads', $fileName);
        }

        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'guardID' => $request->guardID,
            'phone' => $request->phone,
            'idcard' => $request->idcard,
            'district' => $request->district,
            'sector' => $request->sector,
            'image' => $fileName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Optionally link to an employee
        //$employee = Employee::where('email', $request->email)->first();
        if ($user) {
            // $employee->user_id = $user->id;
            // $employee->save();
            notify()->success('User created successfully.');
            return redirect()->route('organization.member');
        }

        notify()->success('User created successfully.');
        // return redirect()->route('users.list');

    }

    public function myProfile()
    {


        $user = Auth::user();

        $loans = Loan::find($user->id);
        // Get the currently logged-in user
        $userId = auth()->id(); // Or auth()->user()->id

        // Retrieve loans that belong to the logged-in user
        $loans = Loan::where('userID', $userId)->get();
        $shares = Share::where('userID', $userId)->get();






        return view('admin.pages.Users.nonEmployeeProfile', compact('user','loans', 'shares'));
    }

    public function userDelete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }

        notify()->success('User Deleted Successfully.');
        return redirect()->back();
    }

    public function userEdit($id)
    {
        $user = User::find($id);
        $employee = Employee::find($id);
        return view('admin.pages.Users.editUser', compact('user', 'employee'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $fileName = $user->image;
            if ($request->hasFile('user_image')) {
                $file = $request->file('user_image');
                $fileName = date('Ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('/uploads', $fileName);
            }

            $user->update([
                'name' => $request->name,
                'role' => $request->role,
                'guardID' => $request->guardID,
                'phone' => $request->phone,
                'idcard' => $request->idcard,
                'district' => $request->district,
                'sector' => $request->sector,
                'image' => $fileName,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // Optionally link to an employee
            $employee = Employee::where('email', $request->email)->first();
            if ($employee) {
                $employee->user_id = $user->id;
                $employee->save();
            }

            notify()->success('User updated successfully.');
            return redirect()->route('users.list');
        }
    }

    public function searchUser(Request $request)
    {
        $searchTerm = $request->search;
        if ($searchTerm) {
            $users = User::where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('role', 'LIKE', '%' . $searchTerm . '%')
                ->get();
        } else {
            $users = User::all();
        }

        return view('admin.pages.Users.searchUserList', compact('users'));
    }
}
