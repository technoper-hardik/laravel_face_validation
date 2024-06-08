<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['user' => \Illuminate\Support\Facades\Auth::user()]);
})->name('welcome');

Route::group([
    'middleware' => ['auth', 'role:Admin']
], function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    /**
     * Self Profile Update
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /**
     * Normal Users Profile Management
     */
    Route::get('/users', [UserController::class, 'create'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

});

require __DIR__ . '/auth.php';
