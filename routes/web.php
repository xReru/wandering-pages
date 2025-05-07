<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Auth\LoginController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/contact-us', function () {
        return view('contact');
    });
    Route::get('/browse-books', [BookController::class, 'index']);

    // Auth Routes
    Route::prefix('admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });

    // Admin Routes
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('books', AdminBookController::class);
        Route::resource('genres', GenreController::class);
    });

    // User Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/test', function () {
        return view('test');
    });
});
