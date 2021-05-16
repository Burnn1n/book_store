<?php

namespace App\Http\Controllers;

use App\Mail\authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function index($email){
        Mail::to($email)->send(new authentication());
        return view('login.verification',compact('email'));
    }
}
