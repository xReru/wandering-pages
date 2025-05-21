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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact-us', function () {
    return view('contact');
})->name('contact-us');

Route::get('/browse-books', [BookController::class, 'index'])->name('browse-books');
Route::get('/api/filtered-books', [BookController::class, 'getFilteredBooks']);
Route::get('/search-books', [BookController::class, 'search']);
Route::get('/books/{book}', [App\Http\Controllers\BookController::class, 'show'])->name('books.show');

// Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/top-selling-products', [App\Http\Controllers\Admin\DashboardController::class, 'getTopSellingProducts']);
    Route::get('/dashboard/order-status', [App\Http\Controllers\Admin\DashboardController::class, 'getOrderStatus']);

    // Book Archive Routes - Place these BEFORE the resource route
    Route::get('/books/archived', [AdminBookController::class, 'archived'])->name('books.archived');
    Route::put('/books/{book}/archive', [AdminBookController::class, 'archive'])->name('books.archive');
    Route::put('/books/{book}/restore', [AdminBookController::class, 'restore'])->name('books.restore');
    Route::delete('/books/{book}/permanent-delete', [AdminBookController::class, 'permanentDelete'])->name('books.permanent-delete');

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

    // Inventory Management Routes
    Route::get('/inventory', [App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/low-stock-alerts', [App\Http\Controllers\Admin\InventoryController::class, 'getLowStockAlerts'])->name('inventory.low-stock-alerts');
});

// Customer Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Customer Signup Routes
Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [SignupController::class, 'signup'])->name('signup.submit');

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
    Route::post('/orders/{order}/cancel', [App\Http\Controllers\Customer\OrderController::class, 'cancel'])->name('orders.cancel');
});

// Password Reset Routes (accessible to guests)
Route::post('/customer/password/email', [CustomerController::class, 'sendResetLinkEmail'])->name('customer.password.email');
Route::post('/customer/password/reset', [CustomerController::class, 'resetPassword'])->name('customer.password.reset');

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
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/update/{item}', [CartController::class, 'updateCartItem']);
    Route::delete('/cart/remove/{item}', [CartController::class, 'removeFromCart']);
});

Route::post('/newsletter/subscribe', [NewsletterSubscriberController::class, 'store'])->name('newsletter.subscribe');

Route::get('/check-profile-completion', function () {
    $customer = auth()->guard('customer')->user();
    
    if (!$customer) {
        return response()->json(['isComplete' => false]);
    }

    $isComplete = !empty($customer->first_name) && 
                 !empty($customer->last_name) && 
                 !empty($customer->phone_number) && 
                 !empty($customer->address);

    return response()->json(['isComplete' => $isComplete]);
})->middleware('auth:customer');

// Test Email Route
Route::get('/test-email', function() {
    try {
        \Mail::raw('This is a test email from your Laravel application.', function($message) {
            $message->to(Auth::guard('customer')->user()->email)
                   ->subject('Test Email');
        });
        return 'Test email sent successfully!';
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
})->middleware('auth:customer');
