<?php

use App\Http\Controllers\Auth\CredentialController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Users\UserController;
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
Route::middleware('guest')->group(function (){
    Route::redirect('/', '/login');
    Route::get('/register', [RegisterController::class , 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login',[LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/password/reset',[CredentialController::class, 'show'])->name('password.request');
    Route::post('/password/email',[CredentialController::class, 'sendMail'])->name('password.email');
    Route::get('/password/reset/{token}',[CredentialController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset',[CredentialController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth','auth.admin'])->group(function () {
    Route::get('home', [UserController::class, 'index'])->name('home');
    Route::resource('users',UserController::class)->except('show');
    Route::get('get-users',[UserController::class, 'getUsers'])->name('get-users');
    Route::get('admin/settings',[ProfileController::class, 'showInfo'])->name('profile');
    Route::put('admin/settings/store/{user}',[ProfileController::class, 'updateInfo'])->name('updateInfo');
    Route::view('admin/password','admin.password')->name('password');
    Route::put('/admin/password/store',[ProfileController::class, 'updatePass'])->name('updatePass');
});

Route::middleware('auth')->group(function () {
    Route::get('/user', function (){
        return view('user.user');
    });
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
