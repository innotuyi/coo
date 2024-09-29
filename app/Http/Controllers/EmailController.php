<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    


    public function sendWelcomeMail() {
        $toemail = 'tuyishimireinnocent56@gmail.com';
        $message = 'Welcome again please';


        Mail::to($toemail)->send(WelcomeMail($message));
    }
}
