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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login()
    {
        return view('admin.pages.AdminLogin.adminLogin');
    }

    public function loginPost(Request $request)
    {
        // Validate the incoming request data
        $val = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required|min:6',
            ]
        );
    
        // If validation fails, redirect back with errors
        if ($val->fails()) {
            return redirect()->back()->withErrors($val)->withInput();
        }
    
        // Determine if the input is an email or phone number
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    
        // Use raw SQL for email or phone authentication
        $credentials = [
            $loginField => $request->input('email'),
            'password' => $request->input('password'),
        ];
    
        // Attempt to authenticate the user using the credentials
        if (auth()->attempt($credentials)) {
            // notify()->success('Successfully Logged in');
            return redirect()->route('dashboard');
        }
    
        // Authentication failed, redirect back with error
        return redirect()->back()->withErrors('Invalid user email or phone number or password');
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
        // Validate the input
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'guardID' => 'nullable|exists:guardians,id',
            'phone' => 'required|min:10|max:10',
            'idcard' => 'required|min:16|max:16',
            'district' => 'required|string',
            'sector' => 'required|string',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_relationship' => 'required|string'
        ]);

        if ($validate->fails()) {
            // Notify the user and return validation errors back to the view
            notify()->error('Invalid Credentials.');
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        // Handle the file upload if it exists
        $fileName = null;
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $fileName = date('Ymdhis') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('/uploads', $fileName, 'public');
        }

        // Insert user data using raw SQL
        // Insert user data using raw SQL
        DB::insert('
INSERT INTO users (name, role, guardID, phone, idcard, district, sector, email, password, user_image,user_relationship, created_at, updated_at)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,NOW(), NOW())', [
            $request->name,
            $request->role,
            $request->guardID,
            $request->phone,
            $request->idcard,
            $request->district,
            $request->sector,
            $request->email,
            Hash::make($request->password),  // Securely hash the password
            $fileName, // The user image filename
            $request->user_relationship,

        ]);

        notify()->success('User created successfully.');
        return redirect()->route('organization.member');
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






        return view('admin.pages.Users.nonEmployeeProfile', compact('user', 'loans', 'shares'));
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
        // $user = User::find($id);
        // return view('admin.pages.Users.editUser', compact('user'));

        $department = User::find($id);
        return view('admin.pages.Organization.Department.editDepartment', compact('department'));
    }
    public function userUpdate(Request $request, $id)
    {
        // Validate the request
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'guardID' => 'nullable|exists:guardians,id',
        //     'phone' => 'required|min:10|max:10',
        //     'idcard' => 'required|min:16|max:16',
        //     'district' => 'required|string',
        //     'sector' => 'required|string',
        //     'email' => 'required|email|unique:users,email,' . $id,
        //     'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'password' => 'nullable|min:6',
        // ]);
    
        // Find the user
        $user = User::find($id);
    
        if ($user) {
            // Handle file upload if it exists
            $fileName = $user->user_image; // Default to existing image
            if ($request->hasFile('user_image')) {
                $file = $request->file('user_image');
                $fileName = date('Ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads', $fileName, 'public');
            }
    
            // Update user details
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'idcard' => $request->idcard,
                'district' => $request->district,
                'sector' => $request->sector,
                'user_image' => $fileName,
                'email' => $request->email,
                'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
            ]);
    
            notify()->success('User updated successfully.');
            return redirect()->route('users.list');
        } else {
            // Handle the case where the user is not found
            notify()->error('User not found.');
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



    public function editProfile()
{
    $user = auth()->user();
    return view('profile.edit', compact('user'));
}

public function updateProfile(Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
        'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'password' => 'nullable|min:6',
    ]);

    // Get the currently authenticated user
    $user = auth()->user();

    // Handle file upload if it exists
    $fileName = $user->user_image;
    if ($request->hasFile('user_image')) {
        $file = $request->file('user_image');
        $fileName = date('Ymdhis') . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads', $fileName, 'public');
    }

    // Update user details
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'user_image' => $fileName,
        'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
    ]);

    notify()->success('Profile updated successfully.');
    return redirect()->back();
}





}
