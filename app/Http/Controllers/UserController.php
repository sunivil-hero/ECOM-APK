<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class userController extends Controller
{
    public function index(){
     // Make sure user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check user type
        if (Auth::user()->user_type == 'admin') {
            return view('admin.dashboard'); // admin dashboard
        }

        if (Auth::user()->user_type == 'user') {
            return view('dashboard'); // regular user dashboard
        }

    }
}
