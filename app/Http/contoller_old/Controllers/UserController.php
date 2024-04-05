<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index()
    {
        echo "Halo, Selamat Datang";
        echo "<h1>".Auth::user()->role->role."</h1>";
        echo "<a href='/logout'> Logout>> </a>";
    }

    function pegawai()
    {
        echo "Halo, Selamat Datang pegawai";
        echo "<h1>".Auth::user()->role->role."</h1>";
        echo "<a href='/logout'> Logout>> </a>";
    }

    function validator()
    {
        echo "Halo, Selamat Datang validator";
        echo "<h1>".Auth::user()->role->role."</h1>";
        echo "<a href='/logout'> Logout>> </a>";
        
    }

    function Admin()
    {
        echo "Halo, Selamat Datang Admin";
        echo "<h1>".Auth::user()->role->role."</h1>";
        echo "<a href='/logout'> Logout>> </a>";
    }
}
