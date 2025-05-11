<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\Customer\CustomerController;

// Public Routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/contact-us', function () {
    return view('contact');
});

Route::get('/browse-books', [BookController::class, 'index']);
Route::get('/books/{book}', [App\Http\Controllers\BookController::class, 'show'])->name('books.show');

// Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('books', AdminBookController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('banner-slides', \App\Http\Controllers\Admin\BannerSlideController::class);

    // CMS Routes
    Route::prefix('cms')->name('cms.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.cms.dashboard');
        })->name('dashboard');
    });

    // Admin Bulk Email Routes
    Route::get('/bulk-email', [App\Http\Controllers\Admin\BulkEmailController::class, 'index'])->name('bulk-email.index');
    Route::post('/bulk-email/send', [App\Http\Controllers\Admin\BulkEmailController::class, 'send'])->name('bulk-email.send');
});

// Customer Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/test', function () {
    return view('test');
});

// Customer Profile Routes
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/customer/profile/check', [CustomerController::class, 'checkProfile'])->name('customer.profile.check');
    Route::get('/customer/profile/setup', [CustomerController::class, 'showStepperForm'])->name('customer.profile.setup');
    Route::post('/customer/profile/setup', [CustomerController::class, 'storeStepperForm'])->name('customer.profile.store');
});

// Protected Customer Routes
Route::middleware(['auth:customer', \App\Http\Middleware\CheckCustomerProfile::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('customers.dash');
    })->name('dashboard');
    // ... other protected routes
});
Route::get('/test-profile', function () {
    return 'Middleware passed.';
})->middleware('customer.profile');

// Cart Routes
Route::middleware(['auth:customer', \App\Http\Middleware\CheckCustomerProfile::class])->group(function () {
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/update/{item}', [CartController::class, 'updateCartItem']);
    Route::delete('/cart/remove/{item}', [CartController::class, 'removeFromCart']);
});

Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [SignupController::class, 'signup']);

Route::post('/newsletter/subscribe', [NewsletterSubscriberController::class, 'store'])->name('newsletter.subscribe');
