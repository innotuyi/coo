<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Expenditure;
use App\Models\Loan;
use App\Models\Meeting;
use App\Models\Member;
use App\Models\Properties;
use App\Models\Punishment;
use App\Models\Share;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function home()
    {

        $a = 'test';

        return view('Frontend.partials.homeDashboard', ['test' => $a]);
    }

    public function dashboard()
    {


        $members = User::count();
        $shares = Share::count();
        $properties = Properties::count();
        $loans = Loan::count();
        $agents = Agent::count();
        $punishments = Punishment::count();
        $meetings = Meeting::count();
        $expenditures = Expenditure::count();




        return view(
            'admin.pages.dashboard',
            compact(
                'members',
                'shares',
                'properties',
                'loans',
                'agents',
                'punishments',
                'meetings',
                'expenditures'
            )
        );
    }
}
