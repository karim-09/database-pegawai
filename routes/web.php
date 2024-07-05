<?php

use App\Http\Controllers\{
    DashboardController,
    DeptController,
    PegawaiController,
    RoleController,
    UserController,
    SettingController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	Route::group(['prefix' => 'dept','middleware' => ['level:dept']], function() {
		Route::get('/', [DeptController::class, 'index'])->name('dept');
		Route::get('/data', [DeptController::class, 'data'])->name('dept.data');
		Route::get('/update/{id}', [DeptController::class, 'show'])->name('dept.show');
		Route::put('/update/{id}', [DeptController::class, 'update'])->name('dept.update');
		Route::delete('/destroy/{id}', [DeptController::class, 'destroy'])->name('dept.destroy');
		Route::post('/store', [DeptController::class, 'store'])->name('dept.store');
	});

	Route::group(['prefix' => 'pegawai','middleware' => ['level:pegawai']], function() {
		Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
		Route::get('/data', [PegawaiController::class, 'data'])->name('pegawai.data');
		Route::get('/update/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
		Route::put('/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
		Route::delete('/destroy/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
		Route::post('/store', [PegawaiController::class, 'store'])->name('pegawai.store');
	});

	Route::group(['prefix' => 'role','middleware' => ['level:role']], function() {
		Route::get('/', [RoleController::class, 'index'])->name('role');
		Route::get('/data', [RoleController::class, 'data'])->name('role.data');
		Route::get('/update/{id}', [RoleController::class, 'show'])->name('role.show');
		Route::put('/update/{id}', [RoleController::class, 'update'])->name('role.update');
		Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
		Route::post('/store', [RoleController::class, 'store'])->name('role.store');
	});

	Route::group(['prefix' => 'user','middleware' => ['level:user']], function() {
		Route::get('/', [UserController::class, 'index'])->name('user');
		Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
		Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
		Route::get('/data', [UserController::class, 'data'])->name('user.data');
		Route::get('/update/{id}', [UserController::class, 'show'])->name('user.show');
		Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
		Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
		Route::post('/store', [UserController::class, 'store'])->name('user.store');
	});

	Route::group(['prefix' => 'kasir','middleware' => ['level:kasir']], function() {
		Route::get('/', [KasirController::class, 'index'])->name('kasir');
		Route::get('/data', [KasirController::class, 'data'])->name('kasir.data');
		Route::get('/update/{id}', [KasirController::class, 'show'])->name('kasir.show');
		Route::put('/update/{id}', [KasirController::class, 'update'])->name('kasir.update');
		Route::delete('/destroy/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');
		Route::post('/store', [KasirController::class, 'store'])->name('kasir.store');
	});

	Route::group(['prefix' => 'setting','middleware' => ['level:setting']], function() {
		Route::get('/', [SettingController::class, 'index'])->name('setting');
		Route::get('/first', [SettingController::class, 'show'])->name('setting.show');
		Route::post('/', [SettingController::class, 'update'])->name('setting.update');
	});
});