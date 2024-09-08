<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CooperativeAccountController extends Controller
{

    // Create
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'nullable|string|max:255',
            'account_number' => 'required|string|unique:cooperative_accounts,account_number|max:255',
            'account_holder_name' => 'required|string|max:255',
            'balance' => 'nullable|numeric',
            'interest_rate' => 'nullable|numeric',
            'opening_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::insert('INSERT INTO cooperative_accounts (type, account_number, account_holder_name, balance, interest_rate, opening_date, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $request->type,
            $request->account_number,
            $request->account_holder_name,
            $request->balance,
            $request->interest_rate,
            $request->opening_date,
        ]);

        return redirect()->route('organization.account')->with('success', 'Account created successfully.');
    }

    // Read
    public function index()
    {
        $accounts = DB::select('SELECT * FROM cooperative_accounts');

        return view('admin.pages.Organization.Department.account', compact('accounts'));    }

    // Update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'nullable|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'balance' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'opening_date' => 'required|date',
            'punishimentDate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::update('UPDATE cooperative_accounts SET type = ?, account_number = ?, account_holder_name = ?, balance = ?, interest_rate = ?, opening_date = ?, punishimentDate = ?, updated_at = NOW() WHERE id = ?', [
            $request->type,
            $request->account_number,
            $request->account_holder_name,
            $request->balance,
            $request->interest_rate,
            $request->opening_date,
            $request->punishimentDate,
            $id
        ]);

        return redirect()->route('cooperative.accounts.index')->with('success', 'Account updated successfully.');
    }

    // Delete
    public function destroy($id)
    {
        DB::delete('DELETE FROM cooperative_accounts WHERE id = ?', [$id]);
        return redirect()->route('cooperative.accounts.index')->with('success', 'Account deleted successfully.');
    }
}

