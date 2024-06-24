<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PgpVerificationController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('admin/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('pgp/verify', [PgpVerificationController::class, 'verify'])->name('pgp.verify');
});

require __DIR__.'/auth.php';

Route::resource('posts', PostController::class);
Route::middleware('auth')->resource('posts.comments', CommentController::class);

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/conversation/{id}', [MessageController::class, 'showConversation'])->name('messages.showConversation');
    Route::get('messages/create', [MessageController::class, 'createConversation'])->name('messages.createConversation');
    Route::post('messages/conversation', [MessageController::class, 'storeConversation'])->name('messages.storeConversation');
    Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
});

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('verify', [AuthenticatedSessionController::class, 'verify'])->name('auth.verify');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('verify-pgp', [RegisteredUserController::class, 'verifyPgpForm'])->name('verify-pgp.form');
Route::post('verify-pgp', [RegisteredUserController::class, 'verifyPgp'])->name('verify-pgp');

Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');
