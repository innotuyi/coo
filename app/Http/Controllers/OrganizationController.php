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
use App\Models\Parking;
use App\Models\Properties;
use App\Models\Punishment;
use App\Models\Share;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'users.*',                // Select all columns from the 'users' table
            'guardians.id as guardian_id',    // Select and alias the 'id' column from 'guardians'
            'guardians.name as guardian_name', // Select and alias the 'name' column from 'guardians'
            'guardians.phone as guardian_phone', // Select and alias the 'phone' column from 'guardians'
            'guardians.idcard as guardian_idcard',
            'guardians.district as guardian_district',
            'guardians.sector as guardian_sector'
        )
            ->leftJoin('guardians', 'guardians.id', '=', 'users.guardID') // Use left join to include users without a guardian
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
            ->join('shares', 'shares.userID', '=', 'm.id')  // Join the 'shares' table on 'userID'
            ->from('users as m') // Set alias for the 'users' table as 'm'
            ->distinct() // Ensure distinct records are returned
            ->get();



        $departments = User::all();

        return view('admin.pages.Organization.Department.share', compact('departments', 'shares'));
    }


    public function shareStore(Request $request)
    {
        // Validate the input
        $validate = Validator::make($request->all(), [
            'userID' => 'required|exists:users,id',            // UserID must exist in the users table
            'amount' => 'nullable|numeric|min:0',              // Amount must be a number greater than or equal to 0
            'joining_date' => 'nullable|date',                 // Joining date must be a valid date
            'amount_increase' => 'nullable|numeric|min:0',     // Amount increase (optional), must be a number
            'total_share' => 'nullable|numeric|min:0',         // Total share
        ]);

        if ($validate->fails()) {
            notify()->error($validate->getMessageBag());
            return redirect()->back();
        }

        $joining_date = Carbon::parse($request->joining_date);

        // Fetch existing values for the user
        $share = DB::table('shares')->where('userID', $request->userID)->first();

        // Calculate total share
        $total_share = $share
            ? $share->amount + $share->amount_increase
            : 0;

        // Insert a new Share record using raw SQL
        DB::insert('
        INSERT INTO shares (userID, amount, joining_date, amount_increase,total_share, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, NOW(), NOW())', [
            $request->userID,
            $request->amount,
            $joining_date,
            $request->amount_increase,
            $total_share + $request->amount + $request->amount_increase
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





    // public function shareUpdate(Request $request, $id)
    // {
    //     // Validate the incoming request data



    //     $validate = Validator::make($request->all(), [
    //         'amount' => 'nullable|numeric|min:0',             // Amount must be a number greater than or equal to 0
    //         'joining_date' => 'nullable|date',                // Joining date must be a valid date
    //         'amount_increase' => 'nullable|numeric|min:0',    // Amount increase (optional), must be a number
    //         'interest_rate' => 'nullable|numeric|min:0|max:100', // Interest rate (optional), between 0 and 100
    //         'total_share' => 'nullable|numeric|min:0',            // Sector is required
    //     ]);



    //     // Check if validation fails
    //     if ($validate->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validate)      // Return with validation errors
    //             ->withInput();                // Return with old input data
    //     }



    //     // Find the guardian by ID
    //     $share = Share::findOrFail($id);

    //     $joining_date = Carbon::parse($request->joining_date);


    //     // Update the guardian record
    //     $share->update([
    //         'amount' => $request->amount,
    //         'joining_date' =>  $joining_date,
    //         'amount_increase' => $request->amount_increase,
    //         'interest_rate' => $request->interest_rate,
    //         'total_share' => $request->total_share,
    //     ]);

    //     notify()->success('Updated successfully.');

    //     return redirect()->route('organization.share');



    //     // // Redirect back with a success message
    //     // return redirect()->back()->with('success', 'Guardian updated successfully');
    // }

    // public function transferShares(Request $request, $shareId)
    // {
    //     try {
    //         // Validate the request
    //         $request->validate([
    //             'recipient_userID' => 'required|exists:users,id',
    //             'amount' => 'required|numeric|min:0',
    //         ]);

    //         // Find the share record
    //         $share = Share::find($shareId);

    //         if (!$share) {
    //             return redirect()->back()->withErrors('Share record not found.');
    //         }

    //         // Ensure the user has enough shares to transfer
    //         if ($share->amount < $request->amount) {
    //             return redirect()->back()->withErrors('Insufficient shares to transfer.');
    //         }

    //         // Transfer shares
    //         $share->update([
    //             'recipient_userID' => $request->recipient_userID,
    //             'transfer_date' => now(),
    //             'amount' => $share->amount - $request->amount, // Reduce the amount of shares in the current record
    //         ]);

    //         // Create a new share record for the recipient
    //         Share::create([
    //             'userID' => $request->recipient_userID,
    //             'amount' => $request->amount, // Set the amount of shares for the recipient
    //             'joining_date' => now(), // Date the shares are received
    //             'interest_rate' => $share->interest_rate, // Use the existing interest rate
    //             'total_share' => $share->total_share, // Use the existing total share
    //         ]);

    //         // Success message
    //         return redirect()->route('organization.sharex')->with('success', 'Shares transferred successfully.');

    //     } catch (\Exception $e) {
    //         // Catch any unexpected errors
    //         return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
    //     }
    // }


    // public function transferShares(Request $request, $shareId)
    // {
    //     // Find the share to be transferred
    //     $share = Share::find($shareId);

    //     if (!$share) {
    //         return redirect()->back()->with('error', 'Share not found.');
    //     }

    //     // Validate the incoming request
    //     $request->validate([
    //         'recipient_userID' => 'required|exists:users,id',
    //         'amount' => 'required|numeric|min:0',
    //     ]);

    //     // // Check if the user has enough shares
    //     // if ($request->amount > $share->total_share) {
    //     //     return redirect()->back()->with('error', 'Insufficient shares to transfer.');
    //     // }

    //     // // Proceed with transferring the shares
    //     // // Assuming you deduct the shares from the current user and transfer them to the recipient
    //     // $share->total_share -= $request->amount; // Deduct from current user
    //     // $share->save();

    //     // Update or create shares for the recipient
    //     $recipientShare = Share::firstOrNew(['userID' => $request->recipient_userID]);
    //     $recipientShare->total_share += $request->amount; // Add to recipient
    //     $recipientShare->save();

    //     return redirect()->back()->with('success', 'Shares transferred successfully.');
    // }
    public function transferShares(Request $request, $shareId)
    {
        // Start a database transaction
        DB::beginTransaction();
    
        try {
            // Step 1: Validate the request
            $request->validate([
                'recipient_userID' => 'required|exists:users,id',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            ]);
    
            // Step 2: Retrieve the share record to be transferred
            $share = DB::table('shares')
                ->select('amount', 'amount_increase')
                ->where('id', $shareId)
                ->first();
    
            if (!$share) {
                return redirect()->back()->withErrors('Share record not found.');
            }
    
            // Step 3: Handle file upload if exists
            $attachmentName = null;
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentName = time() . '_' . uniqid() . '.' . $attachment->getClientOriginalExtension();
                $path = $attachment->storeAs('uploads', $attachmentName, 'public');
    
                if (!$path) {
                    return redirect()->back()->withErrors('Failed to upload attachment.');
                }
            }
    
            // Step 4: Calculate total shares without interest_rate
            $totalShare = $share->amount + ($share->amount_increase ?? 0);
    
            // Step 5: Prepare data for insertion
            $insertData = [
                'userID' => $request->recipient_userID,
                'amount' => $share->amount,
                'amount_increase' => $share->amount_increase,
                'total_share' => $totalShare,
                'joining_date' => now(),
                'attachment' => $attachmentName, // Ensure this matches your table column
                'status' => 'active', // Optional: Set default status
                'created_at' => now(),
                'updated_at' => now(),
            ];
    
            // Step 6: Insert the new share record
            DB::table('shares')->insert($insertData);
    
            // Step 7: Update the original share record's status
            DB::table('shares')->where('id', $shareId)->update([
                'status' => 'transferred',
                'updated_at' => now(),
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Step 8: Redirect with success message
            return redirect()->route('organization.share')->with('success', 'Shares transferred successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
    
            // Log the error for debugging
            Log::error('Error transferring shares:', ['error' => $e->getMessage()]);
    
            // Redirect back with error message
            return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }
    
    












    public function properties()
    {
        // Use raw SQL to fetch all properties
        $departments = DB::select('SELECT * FROM properties');

        return view('admin.pages.Organization.Department.properties', compact('departments'));
    }

    public function propertyStore(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:255',
            'property_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'property_value' => 'required|numeric',
            'property_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'property_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle file uploads
        $fileName = $request->hasFile('property_file')
            ? $request->file('property_file')->storeAs('uploads', date('Ymdhis') . '.' . $request->file('property_file')->getClientOriginalExtension(), 'public')
            : null;

        $attachmentName = $request->hasFile('property_attachment')
            ? $request->file('property_attachment')->storeAs('uploads', date('Ymdhis') . '.' . $request->file('property_attachment')->getClientOriginalExtension(), 'public')
            : null;

        // Convert the property_date to a readable format using Carbon
        $propertyDate = Carbon::parse($request->property_date)->toDateString();

        // Insert the property record using raw SQL
        DB::insert('
            INSERT INTO properties (name, location, comment, property_file, property_value, property_attachment, property_date, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $request->name,
            $request->location,
            $request->comment,
            $fileName,
            $request->property_value,
            $attachmentName,
            $propertyDate
        ]);

        return redirect()->route('organization.properties')
            ->with('success', 'Property created successfully.');
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

        // Update the property record using raw SQL
        DB::update('
        UPDATE properties 
        SET name = ?, location = ?, updated_at = NOW()
        WHERE id = ?', [
            $request->name,
            $request->location,
            $id
        ]);

        // Notify the user about the success
        notify()->success('Property updated successfully.');

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
        // Fetch all meetings using raw SQL
        $departments  = DB::select('SELECT * FROM meetings');

        return view('admin.pages.Organization.Department.meeting', compact('departments'));
    }



    public function meetingStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'descritption' => 'required|string|max:500',
            'meeting_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'meeting_date' => 'required|date'  // Add meeting_date validation
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle file upload if exists
        $attachmentName = null;
        if ($request->hasFile('meeting_attachment')) {
            $attachment = $request->file('meeting_attachment');
            $attachmentName = date('YmdHis') . '.' . $attachment->getClientOriginalExtension();
            $attachment->storeAs('uploads', $attachmentName, 'public');
        }

        // Parse meeting_date with Carbon
        $meetingDate = Carbon::parse($request->meeting_date)->format('Y-m-d');

        // Insert data using raw SQL
        DB::insert('
            INSERT INTO meetings (topic, descritption, meeting_attachment, meeting_date, created_at, updated_at)
            VALUES (?, ?, ?, ?, NOW(), NOW())', [
            $request->topic,
            $request->descritption,
            $attachmentName,
            $meetingDate
        ]);

        return redirect()->route('organization.meeting')
            ->with('success', 'Meeting created successfully');
    }

    public function meetingEdit(Request $request, $id)
    {
        // Fetch the meeting using raw SQL
        $department = DB::select('SELECT * FROM meetings WHERE id = ?', [$id]);

        // Check if the meeting exists
        if ($department) {
            // Since DB::select returns an array, get the first result
            $department = $department[0];

            return view('admin.pages.Organization.Department.meetingEdit', compact('department'));
        } else {
            return redirect()->back()->with('error', 'Meeting not found.');
        }
    }


    public function meetingUpdate(Request $request, $id)
    {
        // Validate the incoming request data
        $validate = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'descritption' => 'required|string|max:500',
        ]);

        // Check if validation fails
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        // Get the current timestamp using Carbon
        $updatedAt = Carbon::now();

        // Update the meeting using raw SQL
        DB::update('
            UPDATE meetings
            SET topic = ?, description = ?, updated_at = ?
            WHERE id = ?
        ', [
            $request->input('topic'),
            $request->input('description'),
            $updatedAt,
            $id
        ]);

        return redirect()->route('organization.meeting')
            ->with('success', 'Meeting updated successfully.');
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

    public function parking()
    {
        // Raw SQL for getting all users
        $departments = DB::select("SELECT * FROM users");

        // Raw SQL for joining parkings and users
        $members = DB::select("
        SELECT parkings.*, users.name as member_name, users.phone as member_phone
        FROM parkings
        INNER JOIN users ON parkings.userID = users.id
    ");

        return view('admin.pages.Organization.Department.parking', compact('members', 'departments'));
    }



    public function parkingStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userID' => 'required|exists:users,id',
            'cost' => 'nullable|numeric',
            'charges' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
            'parking_date' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


           // Step 3: Handle file upload if exists
           $attachmentName = null;
           if ($request->hasFile('attachment')) {
               $attachment = $request->file('attachment');
               $attachmentName = time() . '_' . uniqid() . '.' . $attachment->getClientOriginalExtension();
               $path = $attachment->storeAs('uploads', $attachmentName, 'public');
   
               if (!$path) {
                   return redirect()->back()->withErrors('Failed to upload attachment.');
               }
           }

        // Insert data using raw SQL
        DB::insert('
            INSERT INTO parkings (userID, cost, charges, description,attachment parking_date, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())', [
            $request->userID,
            $request->cost,
            $request->charges,
            $request->description,
            $attachmentName,
            $request->parking_date
        ]);

        return redirect()->route('organization.parking')
            ->with('success', 'parking created successfully.');
    }


    public function parkingEdit($id)
    {

        $department = Parking::join('users', 'parkings.userID', '=', 'users.id')
            ->select('parkings.*', 'users.name as member_name', 'users.phone as member_phone')
            ->where('parkings.id', $id)
            ->firstOrFail();


        return  view('admin.pages.Organization.Department.parkingEdit', compact('department'));
    }


    public function parkingUpdate(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'cost' => 'nullable|numeric',
            'charges' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
            'parking_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::update('
            UPDATE parkings 
            SET cost = ?, charges = ?, description = ?, parking_date = ?, updated_at = NOW() 
            WHERE id = ?', [
            $request->cost,
            $request->charges,
            $request->description,
            $request->parking_date,
            $id
        ]);


        return redirect()->route('organization.parking')
            ->with('success', 'parking updated successfully.');
    }

    public function Deleteparking($id)
    {
        DB::delete('DELETE FROM parkings WHERE id = ?', [$id]);

        return redirect()->route('organization.parking')
            ->with('success', ' parking successfully.');
    }







    public function punishmentStore(Request $request)
    {
        // Validate input
        $validate = Validator::make($request->all(), [
            'userID' => 'required|exists:users,id',
            'description' => 'required|string|max:255',
            'charges' => 'required|numeric|min:0',
            'type' => 'nullable|string|max:255', // Optional punishment type
            'punishimentDate' => 'nullable|date',  // Optional punishment date
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        // Convert the punishment date to a readable format using Carbon
        $punishmentDate = $request->punishimentDate
            ? Carbon::parse($request->punishimentDate)->format('Y-m-d')
            : null;

        // Insert data using raw SQL
        DB::insert('
            INSERT INTO punishments (userID, description, charges, type, punishimentDate, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())', [
            $request->userID,
            $request->description,
            $request->charges,
            $request->type,
            $punishmentDate
        ]);

        return redirect()->route('organization.punishment')
            ->with('success', 'Punishment created successfully.');
    }



    public function punishmentEdit($id)
    {

        $department = DB::table('punishments')
        ->join('users', 'punishments.userID', '=', 'users.id')
        ->select('punishments.*', 'users.name as member_name', 'users.phone as member_phone')
        ->where('punishments.id', $id)
        ->first();

    if (!$department) {
        return redirect()->back()->with('error', 'Punishment not found.');
    }

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


    public function irembo()
    {



        $departments = ExpenditureCategory::all();

        $expenditures = Expenditure::select(
            'expenditures.*',
            'expenditure_categories.name as category_name'
        )
            ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
            ->where('expenditure_categories.name', '=', 'irembo')
            ->get();

        return view('admin.pages.Organization.Department.irembo', compact('departments', 'expenditures'));
    }



    public function bank()
    {



        $departments = ExpenditureCategory::all();

        $expenditures = Expenditure::select(
            'expenditures.*',
            'expenditure_categories.name as category_name'
        )
            ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
            ->where('expenditure_categories.name', '=', 'bank')
            ->get();

        return view('admin.pages.Organization.Department.bank', compact('departments', 'expenditures'));
    }


    public function mobile()
    {



        $departments = ExpenditureCategory::all();

        $expenditures = Expenditure::select(
            'expenditures.*',
            'expenditure_categories.name as category_name'
        )
            ->join('expenditure_categories', 'expenditures.category_id', '=', 'expenditure_categories.id')
            ->where('expenditure_categories.name', '=', 'mobile')
            ->get();

        return view('admin.pages.Organization.Department.bank', compact('departments', 'expenditures'));
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
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:expenditure_categories,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            "bank_type"=>'|string',
            'date' => 'required|date',
            'paid_to' => 'nullable|string',
            'meeting_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        // If validation fails, redirect back with errors and input data
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle the file upload if provided
        $attachmentName = null;
        if ($request->hasFile('meeting_attachment')) {
            $attachment = $request->file('meeting_attachment');
            $attachmentName = date('YmdHis') . '.' . $attachment->getClientOriginalExtension();
            $attachment->storeAs('uploads', $attachmentName, 'public');
        }

        // Convert the date using Carbon
        $date = Carbon::parse($request->date)->toDateString();

        // Insert the data using raw SQL
        DB::insert('
            INSERT INTO expenditures (category_id, description, amount, date, paid_to, bank_type, meeting_attachment, employee_id, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $request->category_id,
            $request->description,
            $request->amount,
            $date,
            $request->paid_to,
            $request->bank_type,
            $attachmentName,
            $request->employee_id,
           
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Expenditure created successfully.');
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
            'bank_type' => $request->input('bank_type'),
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

        // Insert into the 'agents' table using raw SQL
        DB::insert('INSERT INTO agents (name, service, contact, location, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())', [
            $request->name,
            $request->service,
            $request->contact,
            $request->location
        ]);
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
        // Check if the agent exists
        $agent = DB::select('SELECT * FROM agents WHERE id = ?', [$id]);

        if (!$agent) {
            return redirect()->back()->withErrors(['Agent not found.'])->withInput();
        }

        // Update using raw SQL
        DB::update('UPDATE agents SET name = ?, service = ?, contact = ?, location = ?, updated_at = NOW() WHERE id = ?', [
            $request->name,
            $request->service,
            $request->contact,
            $request->location,
            $id,
        ]);
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

        // Validate the input
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required|exists:agents,id',
            'profit' => 'required|numeric',
            'month' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Insert using raw SQL
        DB::insert('INSERT INTO agent_profits (agent_id, profit, month, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', [
            $request->agent_id,
            $request->profit,
            $request->month,
        ]);

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
        // Validate the input
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'idcard' => 'required|digits:16|unique:guardians,idcard',
            'district' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'guardian_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validate guardian image
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        // Handle the file upload if it exists
        $fileName = null;
        if ($request->hasFile('guardian_image')) {
            $file = $request->file('guardian_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // Create a unique file name
            $file->storeAs('uploads', $fileName, 'public'); // Store in storage/app/public/uploads
        }

        // Insert guardian data using raw SQL
        DB::insert('
        INSERT INTO guardians (name, phone, idcard, district, sector, guardian_image, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
    ', [
            $request->name,
            $request->phone,
            $request->idcard,
            $request->district,
            $request->sector,
            $fileName
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

        DB::insert('INSERT INTO members (name, guardID, phone, idcard, district, sector, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $request->name,
            $request->guardID,
            $request->phone,
            $request->idcard,
            $request->district,
            $request->sector
        ]);

        notify()->success('New Member created successfully.');
        return redirect()->back();
        notify()->success('New member created successfully.');
        return redirect()->back();
    }

    public function delete($id)
    {
        $department = Guardian::find($id);
        if ($department) {
            $department->delete();
        }
        // notify()->success('Guardian Deleted Successfully.');
        return redirect()->back();
    }
    public function edit($id)
    {
        $department = DB::select('SELECT * FROM guardians WHERE id = ?', [$id]);

    // Since DB::select returns an array of results, get the first record
    $department = $department[0] ?? null;

    if (!$department) {
        // Handle the case where the record isn't found
        return redirect()->back()->with('error', 'Guardian not found.');
    }
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
