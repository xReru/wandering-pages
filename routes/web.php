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
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\LikeController;

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

    // Order Management Routes
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/bulk-update', [App\Http\Controllers\Admin\OrderController::class, 'bulkUpdate'])->name('orders.bulk-update');
    Route::get('/orders/{order}/waybill', [App\Http\Controllers\Admin\OrderController::class, 'waybill'])->name('orders.waybill');
});

// Customer Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Customer Profile Routes
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/customer/profile/check', [CustomerController::class, 'checkProfile'])->name('customer.profile.check');
    Route::get('/customer/profile/setup', [CustomerController::class, 'showStepperForm'])->name('customer.profile.setup');
    Route::post('/customer/profile/setup', [CustomerController::class, 'storeStepperForm'])->name('customer.profile.store');
    Route::post('/customer/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/dashboard', function () {
        return view('customers.profile-info');
    })->name('dashboard');
    Route::post('/customer/password/change', [CustomerController::class, 'changePassword'])->name('customer.password.change');
});

// Protected Customer Routes
Route::middleware(['auth:customer', \App\Http\Middleware\CheckCustomerProfile::class])->group(function () {
    Route::get('/customers/order/order-checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/customers/order/submit', [OrderController::class, 'submitOrder'])->name('order.submit');
    Route::get('/customers/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/customers/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/customers/orders/shipping', [OrderController::class, 'shipping'])->name('orders.shipping');
    Route::get('/customers/orders/delivering', [OrderController::class, 'delivering'])->name('orders.delivering');
    Route::get('/customers/orders/rating', [OrderController::class, 'completed'])->name('orders.completed');
    Route::get('/customers/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/customers/likes', [\App\Http\Controllers\LikeController::class, 'index'])->name('customers.likes');
    Route::post('/likes', [\App\Http\Controllers\LikeController::class, 'store'])->name('likes.store');
    Route::delete('/likes', [\App\Http\Controllers\LikeController::class, 'destroy'])->name('likes.destroy');
    Route::get('orders/history', [OrderController::class, 'history'])->name('orders.history');
});

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
