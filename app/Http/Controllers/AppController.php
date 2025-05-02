<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return view('welcome');
        }
        
        return redirect()->route('login');
    }
} 