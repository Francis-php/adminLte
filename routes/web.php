<?php

use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Agency\AgencyController;
use App\Http\Controllers\Agency\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Auth\CredentialController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\UserController;
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
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/password/reset', [CredentialController::class, 'show'])->name('password.request');
    Route::post('/password/email', [CredentialController::class, 'sendMail'])->name('password.email');
    Route::get('/password/reset/{token}', [CredentialController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [CredentialController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth', 'verified', 'auth.admin'])->group(function () {
    Route::get('home', [UsersController::class, 'index'])->name('home');
    Route::resource('users',UsersController::class)->except('show');
    Route::put('users/{user}/image', [UsersController::class, 'updatePicture'])->name('updatePicUser');
    Route::get('get-users', [UsersController::class, 'getUsers'])->name('get-users');
    Route::get('admin/settings', [ProfileController::class, 'showInfo'])->name('profile');
    Route::put('admin/settings/store/{user}', [ProfileController::class, 'updateInfo'])->name('updateInfo');
    Route::put('admin/settings/store/image/{user}', [ProfileController::class, 'updatePicture'])->name('updatePic');
    Route::put('/admin/settings/delete/{user}', [ProfileController::class,'deletePicture'])->name('deletePic');
    Route::put('/admin/password/store/{user}', [ProfileController::class, 'updatePass'])->name('updatePass');
    Route::get('/posts', [AdminPostController::class, 'read'])->name('admin-show-posts');
    Route::get('/agencies', [AdminPostController::class, 'showAgencies'])->name('show-agencies');
    Route::get('/agency/{agencyId}', [AdminPostController::class, 'showAgency'])->name('show-agency');

});

Route::middleware(['auth', 'verified', 'auth.user'])->group(callback: function () {
    Route::get('/user', [UserController::class,'showPosts'])->name('user.show');
    Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
    Route::put('/user/profile/store/information/{user}', [ProfileController::class, 'updateInfo'])->name('update-user-information');
    Route::put('/user/profile/store/image/{user}', [ProfileController::class, 'updatePicture'])->name('update-user-picture');
    Route::put('/user/profile/delete/image/{user}', [ProfileController::class,'deletePicture'])->name('delete-user-picture');
    Route::put('/user/profile/store/password/{user}', [ProfileController::class, 'updatePass'])->name('update-user-password');
    Route::post('/user/post/apply/{post}', [UserController::class, 'applyPost'])->name('apply-post');
    Route::put('/user/post/modify/{post}', [UserController::class, 'modifyReservation'])->name('modify-reservation');
    Route::delete('/user/post/remove/{post}', [UserController::class, 'cancelApplication'])->name('cancel-application');
    Route::get('/user/reservation-history', [UserController::class, 'showReservations'])->name('reservation-history');
});

Route::middleware(['auth', 'verified', 'auth.agency'])->group(function (){
    Route::get('/agency/profile', [AgencyController::class, 'show'])->name('agency.profile');
    Route::put('/agency/profile/store/information/{user}', [ProfileController::class, 'updateInfo'])->name('update-agency-information');
    Route::put('/agency/profile/store/image/{user}', [ProfileController::class, 'updatePicture'])->name('update-agency-picture');
    Route::put('/agency/profile/delete/image/{user}', [ProfileController::class,'deletePicture'])->name('delete-agency-picture');
    Route::put('/agency/profile/store/password/{user}', [ProfileController::class, 'updatePass'])->name('update-agency-password');
    Route::get('/agency', [PostsController::class, 'read'])->name('agency.main_page');
    Route::get('/posts/create', [PostsController::class, 'create'])->name('create-post');
    Route::post('/posts/store', [PostsController::class, 'store'])->name('store-post');
    Route::get('/agency/post/edit/{post}', [PostsController::class, 'showPost'])->name('edit-post');
    Route::put('/agency/post/edit/information/{post}', [PostsController::class, 'update'])->name('edit-post-information');
    Route::put('/agency/post/edit/add-image/{post}', [PostsController::class, 'addPostImage'])->name('add-post-image');
    Route::delete('/agency/post/delete/{post}', [PostsController::class, 'delete'])->name('delete-post');
    Route::delete('/agency/post/delete/image/{image}', [PostsController::class, 'deleteImage'])->name('delete-post-image');


    Route::get('/agency/posts/{post}/applications', [PostsController::class, 'showApplications'])->name('show-applications');


    Route::delete('/agency/post/application/delete/{user}/{post}', [PostsController::class, 'deleteApplication'])->name('delete-application');
});

Route::middleware('auth')->group(callback: function (){
    Route::get('/email/verify', [RegisterController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [RegisterController::class, 'resend'])->name('verification.resend');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});




