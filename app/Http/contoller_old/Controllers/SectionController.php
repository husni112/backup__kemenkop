<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    function index()
    {
        return view('login');
    }
    function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ],[
            'nik.required' => 'NIK Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);

        if(Auth::attempt(['nik'=> $request->nik, 'password'=> $request->password])){
            if(Auth::user()->role_id == 1){
                return redirect('user/admin');
            } elseif(Auth::user()->role_id == 2){
                return redirect('user/validator');
            } elseif(Auth::user()->role_id == 3){
                return redirect('user/pegawai');
            }
        }
        return back()->withErrors([
            'nik' => 'The provided credentials do not match our records.',
        ])->onlyInput('nik');
    }

    function logout(){
        Auth::logout();
        return redirect('');
    }
}
