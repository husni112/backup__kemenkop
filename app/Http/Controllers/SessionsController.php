<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    function index()
    {
        return view('session.login-session');
    }
    function login(Request $attributes)
    {
        $attributes = request()->validate([
            'nik' => 'required',
            'password' => 'required', 
        ],[
            'nik.required' => 'NIK Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);

        if(Auth::attempt($attributes)){
            session()->regenerate();
                return redirect('dashboard')->with(['success'=>'You are logged in.']);
        } else {
        return back()->withErrors([
            'nik' => 'The provided credentials do not match our records.',
            ])->onlyInput('nik');
        }
    }
    
    public function logout()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }
}
