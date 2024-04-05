<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportPaguController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', [HomeController::class, 'home'])->name('dashboard');
	Route::get('/search', [HomeController::class, 'search'])->name('data');

	Route::get('/buat-berkas', [PengajuanController::class, 'showForm']);
	Route::post('/buat-berkas', [PengajuanController::class, 'storeData'])->name('storeData');
	Route::delete('/delete-berkas/{id}', [PengajuanController::class, 'removeData'])->name('removeData');

	Route::get('/pengajuan/get', [PengajuanController::class, 'getIdBerkas'])->name('pengajuan');
	Route::get('/pengajuan/{id}', [PengajuanController::class, 'buatPengajuan'])->name('pengajuan');
	Route::get('/get-provinsis', [PengajuanController::class, 'getProvinsis']);
	Route::post('/get-kotas', [PengajuanController::class, 'getKotas'])->name('getKotas');
	Route::post('/validate', [PengajuanController::class, 'validateData'])->name('validate');
	Route::post('/daftar-npwp-swakelola', [PengajuanController::class, 'formNpwpRegistration'])->name('daftar-npwp-swakelola');

	Route::post('/submitFormPengajuan', [PengajuanController::class, 'submitFormPengajuan']);

	Route::get('/import-pagu', [ImportPaguController::class, 'index'])->name('import-pagu');
	Route::post('/data-import', [ImportPaguController::class, 'import']);

	Route::get('riwayat-pengajuan', function () {
		return view('riwayat-pengajuan');
	})->name('riwayat-pengajuan');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'logout']);
	Route::get('/user-profile', [InfoUserController::class, 'index']);
	Route::post('/user-profile', [InfoUserController::class, 'login']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'login']);
    Route::get('/login', [SessionsController::class, 'index']);
    Route::post('/session', [SessionsController::class, 'login']);
	Route::get('/login/forgot-password', [ResetController::class, 'index']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');