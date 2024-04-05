<?php

use App\Http\Controllers\CsvImportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Models\Akun;
use App\Models\Sub_komponen;

Route::middleware(['guest'])->group(function (){
    Route::get('/', [SectionController::class,'index'])->name('login');
    Route::post('/', [SectionController::class,'login']);
});

Route::middleware(['auth'])->group(function (){
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/pegawai', [UserController::class, 'pegawai'])->middleware('accessUser');
    Route::get('/user/validator', [UserController::class, 'validator'])->middleware('accessUser');
    Route::get('/user/admin', [UserController::class, 'admin'])->middleware('accessUser');
    Route::get('/logout', [SectionController::class, 'logout']);
});

Route::get('/home', function (){
    return redirect('/user');
});

Route::get('import', [CsvImportController::class, 'index']);
Route::post('/data-import', [CsvImportController::class, 'import']);

Route::get('/test', function () {
    return view('layouts/app');
});
Route::get('/test2', function () {
    return view('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
