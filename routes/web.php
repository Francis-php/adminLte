<?php

use App\Http\Controllers\Auth\CredentialController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\SimpleUserController;
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

Route::middleware(['auth','verified','auth.admin'])->group(function () {
    Route::get('home', [UserController::class, 'index'])->name('home');
    Route::resource('users',UserController::class)->except('show');
    Route::put('users/{user}/image',[UserController::class, 'updatePicture'])->name('updatePicUser');
    Route::get('get-users',[UserController::class, 'getUsers'])->name('get-users');
    Route::get('admin/settings',[ProfileController::class, 'showInfo'])->name('profile');
    Route::put('admin/settings/store/{user}',[ProfileController::class, 'updateInfo'])->name('updateInfo');
    Route::put('admin/settings/store/image/{user}',[ProfileController::class, 'updatePicture'])->name('updatePic');
    Route::put('/admin/settings/delete/{user}',[ProfileController::class,'deletePicture'])->name('deletePic');
    Route::put('/admin/password/store/{user}',[ProfileController::class, 'updatePass'])->name('updatePass');
});

Route::middleware(['auth','verified'])->group(callback: function () {
    Route::get('/user',[SimpleUserController::class,'show'])->name('user.show');
    Route::get('/user/profile', [SimpleUserController::class, 'showProfile'])->name('user.profile');
    Route::put('/user/profile/store/information/{user}',[ProfileController::class, 'updateInfo'])->name('update-user-information');
    Route::put('/user/profile/store/image/{user}',[ProfileController::class, 'updatePicture'])->name('update-user-picture');
    Route::put('/user/profile/delete/image/{user}',[ProfileController::class,'deletePicture'])->name('delete-user-picture');
    Route::put('/user/profile/store/password/{user}',[ProfileController::class, 'updatePass'])->name('update-user-password');
});

Route::middleware('auth')->group(callback: function (){
    Route::get('/email/verify', [RegisterController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [RegisterController::class, 'resend'])->name('verification.resend');

});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


