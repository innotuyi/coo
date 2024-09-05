<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentProfit;
use App\Models\Department;
use App\Models\Expenditure;
use App\Models\ExpenditureCategory;
use App\Models\Guardian;
use App\Models\Meeting;
use App\Models\Member;
use App\Models\Properties;
use App\Models\Punishment;
use App\Models\Share;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    public function department()
    {
        $guardians = Guardian::all();
        return view('admin.pages.Organization.Department.guardian', compact('guardians'));
    }


    public function member()
    {
        $members = User::select(
            'users.*',                // Select all columns from the 'members' table
            'guardians.id as guardian_id',    // Select and alias the 'id' column from 'guardians'
            'guardians.name as guardian_name', // Select and alias the 'name' column from 'guardians'
            'guardians.phone as guardian_phone', // Select and alias any other guardian columns
            'guardians.idcard as guardian_idcard',
            'guardians.district as guardian_district',
            'guardians.sector as guardian_sector'
        )
            ->join('guardians', 'guardians.id', '=', 'users.guardID') // Adjust the foreign key
            ->get();
        $departments = Guardian::all();
        return view('admin.pages.Organization.Department.members', compact('departments', 'members'));
    }

    public function share()
    {
        $shares = User::select(
            'shares.*',                // Select all columns from the 'shares' table
            'm.id as member_id',        // Select and alias the 'id' column from the alias 'm'
            'm.name as member_name',    // Alias 'name' from the alias 'm'
            'm.phone as member_phone',  // Alias 'phone' from the alias 'm'
            'm.idcard as member_idcard',
            'm.district as member_district',
            'm.sector as member_sector'
        )
            ->join('shares', 'shares.userID', '=', 'm.id')  // Alias the members table as 'm'
            ->from('users as m') // Set alias for the members table
            ->get();


        $departments = User::all();

        return view('admin.pages.Organization.Department.share', compact('departments', 'shares'));
    }


    public function shareStore(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'userID' => 'required|exists:users,id',       // Member ID must exist in the members table
            'amount' => 'nullable|numeric|min:0',             // Amount must be a number greater than or equal to 0
            'joining_date' => 'nullable|date',                // Joining date must be a valid date
            'amount_increase' => 'nullable|numeric|min:0',    // Amount increase (optional), must be a number
            'interest_rate' => 'nullable|numeric|min:0', // Interest rate (optional), between 0 and 100
            'total_share' => 'nullable|numeric|min:0',            // Sector is required
        ]);

        if ($validate->fails()) {

            notify()->error($validate->getMessageBag());
            return redirect()->back();
        }

        $joining_date = Carbon::parse($request->joining_date);

        // Fetch existing values for the user
        $share = Share::where('userID', $request->userID)->first();

        // If the user has previous records, calculate the total share
        if ($share) {
            $total_share = $share->amount + $share->amount_increase + $share->interest_rate;
        } else {
            // If no previous record, set it to zero
            $total_share = 0;
        }

        // Create a new Share record with updated fields
        Share::create([
            'userID' => $request->userID,
            'amount' => $request->amount,
            'joining_date' => $joining_date,
            'amount_increase' => $request->amount_increase,
            'interest_rate' => $request->interest_rate,
            // Add the fetched values to the new ones
            'total_share' => $total_share + $request->amount + $request->amount_increase + $request->interest_rate,
        ]);

        notify()->success('New share created successfully.');
        return redirect()->back();
    }


    public function shareEdit($id)
    {
        $department = Member::select(
            'shares.*',                // Select all columns from the 'shares' table
            'm.id as member_id',        // Select and alias the 'id' column from the alias 'm'
            'm.name as member_name',    // Alias 'name' from the alias 'm'
            'm.phone as member_phone',  // Alias 'phone' from the alias 'm'
            'm.idcard as member_idcard',
            'm.district as member_district',
            'm.sector as member_sector'
        )
            ->join('shares', 'shares.userID', '=', 'm.id')  // Join on the memberID field and alias members table as 'm'
            ->from('users as m')                            // Set alias for the members table
            ->where('shares.id', $id)                         // Filter by share ID
            ->first();                                        // Retrieve the first matching record

        if ($department) {
            return view('admin.pages.Organization.Department.editShare', compact('department'));
        } else {
            return redirect()->back()->with('error', 'Share not found.');
        }
    }



    public function shareDelete($id)
    {
        $department = Share::find($id);
        if ($department) {
            $department->delete();
        }
        notify()->success('share Deleted Successfully.');
        return redirect()->back();
    }



    public function shareUpdate(Request $request, $id)
    {
        // Validate the incoming request data



        $validate = Validator::make($request->all(), [
            'amount' => 'nullable|numeric|min:0',             // Amount must be a number greater than or equal to 0
            'joining_date' => 'nullable|date',                // Joining date must be a valid date
            'amount_increase' => 'nullable|numeric|min:0',    // Amount increase (optional), must be a number
            'interest_rate' => 'nullable|numeric|min:0|max:100', // Interest rate (optional), between 0 and 100
            'total_share' => 'nullable|numeric|min:0',            // Sector is required
        ]);



        // Check if validation fails
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)      // Return with validation errors
                ->withInput();                // Return with old input data
        }



        // Find the guardian by ID
        $share = Share::findOrFail($id);

        $joining_date = Carbon::parse($request->joining_date);


        // Update the guardian record
        $share->update([
            'amount' => $request->amount,
            'joining_date' =>  $joining_date,
            'amount_increase' => $request->amount_increase,
            'interest_rate' => $request->interest_rate,
            'total_share' => $request->total_share,
        ]);

        notify()->success('Updated successfully.');

        return redirect()->route('organization.share');



        // // Redirect back with a success message
        // return redirect()->back()->with('success', 'Guardian updated successfully');
    }




    public function properties()
    {
        $departments = Properties::all();
        return view('admin.pages.Organization.Department.properties', compact('departments'));
    }

    public function propertyStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        Properties::create($request->all());


        return redirect()->route('organization.properties');
    }

    public function propertyEdit($id)
    {

        $department = Properties::find($id);


        if ($department) {
            return view('admin.pages.Organization.Department.propertyEdit', compact('department'));
        } else {
            return redirect()->back()->with('error', 'property not found.');
        }
    }


    public function propertyUpdate(Request $request, $id)
    {

        // Validate the incoming request data

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);



        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)      // Return with validation errors
                ->withInput();                // Return with old input data
        }
        // Find the guardian by ID
        $property = Properties::findOrFail($id);



        // Update the guardian record
        $property->update([
            'name' => $request->name,
            'location' =>  $request->location,

        ]);

        notify()->success('Updated successfully.');

        return redirect()->route('organization.properties');
    }



    public function deleteProperty($id)
    {

        $department = Properties::find($id);
        if ($department) {
            $department->delete();
        }
        notify()->success('Property Deleted Successfully.');
        return redirect()->back();
    }


    public function meeting()
    {
        $departments = Meeting::all();
        return view('admin.pages.Organization.Department.meeting', compact('departments'));
    }



    public function meetingStore(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'descritption' => 'required|string|max:500',
        ]);


        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        Meeting::create($request->all());


        return redirect()->route('organization.meeting');
    }

    public function meetingEdit(Request $request, $id)
    {

        $department = Meeting::find($id);



        if ($department) {
            return view('admin.pages.Organization.Department.meetingEdit', compact('department'));
        } else {
            return redirect()->back()->with('error', 'meeting not found.');
        }
    }


    public function meetingUpdate(Request $request, $id)
    {

        $validate = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'descritption' => 'required|string|max:500',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $meeting = Meeting::findOrFail($id);

        $meeting->update($request->all());;

        return redirect()->route('organization.meeting')
            ->with('success', 'Meeting deleted successfully.');
    }


    public function deleteMeeting($id)
    {


        $meeting = Meeting::findOrFail($id);
        $meeting->delete();

        return redirect()->route('organization.meeting')
            ->with('success', 'Meeting deleted successfully.');
    }

    public function punishment()
    {
        $departments = User::all();

        $members = Punishment::join('users', 'punishments.userID', '=', 'users.id')
            ->select('punishments.*', 'users.name as member_name', 'users.phone as member_phone')
            ->get();


        return view('admin.pages.Organization.Department.punishment', compact('members', 'departments'));
    }


    public function punishmentStore(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'userID' => 'required|exists:users,id',
            'description' => 'required|string|max:255',
            'charges' => 'required|numeric|min:0',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        Punishment::create($request->all());

        return redirect()->route('organization.punishment')
            ->with('success', 'punishment created successfully.');
    }


    public function punishmentEdit($id)
    {

        $department = Punishment::join('members', 'punishments.memberID', '=', 'members.id')
            ->select('punishments.*', 'members.name as member_name', 'members.phone as member_phone')
            ->where('punishments.id', $id)
            ->firstOrFail();


        return  view('admin.pages.Organization.Department.punishmentEdit', compact('department'));
    }

    public function punishmentUpdate(Request $request, $id)
    {

        $validate = Validator::make($request->all(), [
            // 'memberID' => 'required|exists:members,id',
            'description' => 'required|string|max:255',
            'charges' => 'required|numeric|min:0',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $punishment = Punishment::findOrFail($id);
        $punishment->update($request->all());

        return redirect()->route('organization.punishment')
            ->with('success', 'Punishment updated successfully.');
    }

    public function Deletepunishment($id)
    {

        $punishment = Punishment::findOrFail($id);
        $punishment->delete();

        return redirect()->route('organization.punishment')
            ->with('success', 'Punishment deleted successfully.');
    }


    public function expendutureCategory()
    {


        $departments = ExpenditureCategory::all();

        return view('admin.pages.Organization.Department.expendutureCategory', compact('departments'));
    }
    public function expendutureCategoryStore(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ExpenditureCategory::create($request->all());

        return redirect()->route('organization.expendutureCategory')
            ->with('success', 'Expenditure category created successfully.');
    }


    public function expendutureCategoryEdit($id)
    {


        $department = ExpenditureCategory::findOrFail($id);

        return view('admin.pages.Organization.Department.expendutureEdit', compact('department'));
    }

    public function expendutureCategoryUpdate(Request $request, $id)
    {


        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = ExpenditureCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('organization.expendutureCategory')
            ->with('success', 'Expenditure category updated successfully.');
    }

    public function expendutureCategoryDelete($id)
    {

        $category = ExpenditureCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('organization.expendutureCategory')
            ->with('success', 'Expenditure category deleted successfully.');
    }

    public function expenduture()
    {
        $departments = ExpenditureCategory::all();

        $expenditures = Expenditure::select(
            'expenditures.*',
            'expenditure_categories.name as category_name'
        )
            ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
            ->get();
        return view('admin.pages.Organization.Department.expenduture', compact('departments', 'expenditures'));
    }


    public function expendutureStore(Request $request)
    {


        // Create the validator instance using Validator::make
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:expenditure_categories,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'paid_to' => 'nullable|string',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)      // Return with validation errors
                ->withInput();                // Return with old input data
        }
        $data = $request->all();
        $data['date'] = Carbon::parse($request->date)->toDateString();

        // Create the expenditure with the parsed date
        Expenditure::create($data);

        return redirect()->route('organization.expenduture')
            ->with('success', 'Expenditure  created successfully.');
    }

    public function expendutureEdit($id)
    {

        // $expenditure = Expenditure::findOrFail($id);
        $department = Expenditure::select(
            'expenditures.*',                          // Select all fields from the expenditures table
            'expenditure_categories.name as category_name' // Join and select category name
        )
            ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
            ->where('expenditures.id', $id)                // Filter by the expenditure ID
            ->firstOrFail();                               // Retrieve the first matching result or fail if not found

        //$employees = Employee::all();
        return view('admin.pages.Organization.Department.expendutureEdit', compact('department'));
    }

    public function  expendutureUpdate(Request $request, $id)
    {



        $expenditure = Expenditure::findOrFail($id);

        // Parse and format the 'date' using Carbon
        $formattedDate = Carbon::parse($request->input('date'))->format('Y-m-d');

        // Update the expenditure, passing the Carbon date separately
        $expenditure->update([
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'date' => $formattedDate,  // Use the formatted Carbon date
            'paid_to' => $request->input('paid_to'),
            'employee_id' => $request->input('employee_id'),
        ]);
        return redirect()->route('organization.expenduture')
            ->with('success', 'Expenditure updated successfully.');
    }

    public function expendutureDelete($id)
    {


        $expenditure = Expenditure::findOrFail($id);
        $expenditure->delete();

        return redirect()->route('organization.expenduture');
    }






    public function agent()
    {
        $departments = Agent::all();

        return view('admin.pages.Organization.Department.agent', compact('departments'));
    }

    public function agentStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Agent::create($request->all());
        return redirect()->route('organization.agent')->with('success', 'Agent created successfully.');
    }

    public function agentEdit($id)
    {
        $department = Agent::find($id);

        return view('admin.pages.Organization.Department.editAgent', compact('department'));
    }

    public function agentUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $agent = Agent::findOrFail($id);

        $agent->update($request->all());

        return redirect()->route('organization.agent')->with('success', 'Agent updated successfully.');
    }

    public function agentDelete($id)
    {

        $agent = Agent::findOrFail($id);
        $agent->delete();
        return redirect()->route('organization.agent')->with('success', 'Agent deleted successfully.');
    }



    public function agentProfit()
    {

        $departments = Agent::all();

        $agentProfits = AgentProfit::join('agents', 'agent_profits.agent_id', '=', 'agents.id')
            ->select('agent_profits.*', 'agents.name as agent_name', 'agents.service as agent_service')
            ->get();

        return view('admin.pages.Organization.Department.agentProfit', compact('departments', 'agentProfits'));
    }


    public function agentProfitStore(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'agent_id' => 'required|exists:agents,id',
            'profit' => 'required|numeric',
            'month' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        AgentProfit::create($request->all());

        return redirect()->route('organization.agentProfit')->with('success', 'Agent Profit added successfully.');
    }


    public function agentProfitEdit($id)
    {

        $department =  AgentProfit::select(
            'agent_profits.*',
            'agents.name as agent_name',
            'agents.service as agent_service',
            'agents.contact as agent_contact',
            'agents.location as agent_location'
        )
            ->join('agents', 'agent_profits.agent_id', '=', 'agents.id')
            ->where('agent_profits.id', $id)
            ->firstOrFail();

        $agents = Agent::all();
        return view('admin.pages.Organization.Department.editAgentProfit', compact('department', 'agents'));
    }

    public function agentProfitUpdate(Request $request, $id)
    {
        // Use Validator::make to handle validation manually
        $validator = Validator::make($request->all(), [
            // 'agent_id' => 'required|exists:agents,id',
            'profit' => 'required|numeric',
            'month' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)  // Return with validation errors
                ->withInput();            // Return the input data
        }

        // If validation passes, proceed with the update
        $validated = $validator->validated();

        $agentProfit = AgentProfit::findOrFail($id);
        $agentProfit->update($validated);


        return redirect()->route('organization.agentProfit')->with('success', 'Agent Profit updated successfully.');
    }


    public function agentProfitDelete($id)
    {
        $agentProfit = AgentProfit::findOrFail($id);
        $agentProfit->delete();
        return redirect()->route('organization.agentProfit')->with('success', 'Agent Profit deleted successfully.');
    }




























    public function departmentList()
    {
        $guardians = Guardian::all();
        return view('admin.pages.Organization.Department.department', compact('guardians'));
    }
    public function store(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',            // Guardian name
            'phone' => 'required|digits:10', // Exactly 10 digits for phone number
            'idcard' => 'required|digits:16|unique:guardians,idcard', // Exactly 16 digits for ID card, must be unique
            'district' => 'required|string|max:255',        // District is required
            'sector' => 'required|string|max:255',          // Sector is required
        ]);

        if ($validate->fails()) {

            notify()->error($validate->getMessageBag());
            return redirect()->back();

            return redirect()->back()->withErrors($validate);
        }

        Guardian::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'idcard' => $request->idcard,
            'district' => $request->district,
            'sector' => $request->sector,
        ]);
        notify()->success('New Guardian created successfully.');
        return redirect()->back();
    }

    public function memberStore(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',            // Guardian name
            'phone' => 'required|digits:10', // Exactly 10 digits for phone number
            'idcard' => 'required|digits:16|unique:guardians,idcard', // Exactly 16 digits for ID card, must be unique
            'district' => 'required|string|max:255',        // District is required
            'sector' => 'required|string|max:255',          // Sector is required
        ]);

        if ($validate->fails()) {

            notify()->error($validate->getMessageBag());
            return redirect()->back();

            return redirect()->back()->withErrors($validate);
        }

        Member::create([
            'name' => $request->name,
            'guardID' => $request->guardID,
            'phone' => $request->phone,
            'idcard' => $request->idcard,
            'district' => $request->district,
            'sector' => $request->sector,
        ]);
        notify()->success('New member created successfully.');
        return redirect()->back();
    }

    public function delete($id)
    {
        $department = Guardian::find($id);
        if ($department) {
            $department->delete();
        }
        notify()->success('Guardian Deleted Successfully.');
        return redirect()->back();
    }
    public function edit($id)
    {
        $department = Guardian::find($id);
        return view('admin.pages.Organization.Department.editDepartment', compact('department'));
    }


    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10', // Exactly 10 digits for phone number
            'idcard' => 'required|digits:16|unique:guardians,idcard,' . $id, // Ensure ID card is unique except for the current record
            'district' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)      // Return with validation errors
                ->withInput();                // Return with old input data
        }

        // Find the guardian by ID
        $guardian = Guardian::findOrFail($id);

        // Update the guardian record
        $guardian->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'idcard' => $request->idcard,
            'district' => $request->district,
            'sector' => $request->sector,
        ]);

        notify()->success('Updated successfully.');
        return redirect()->route('organization.department');




        // // Redirect back with a success message
        // return redirect()->back()->with('success', 'Guardian updated successfully');
    }














    public function searchDepartment(Request $request)
    {
        $searchTerm = $request->search;

        $departments = Department::where(function ($query) use ($searchTerm) {
            $query->where('department_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('department_id', 'LIKE', '%' . $searchTerm . '%');
        })->paginate(10);

        return view('admin.pages.Organization.Department.searchDepartment', compact('departments'));
    }
}
