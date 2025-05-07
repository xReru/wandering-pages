<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('home');
});

Route::get('/browse-books', [BookController::class, 'index']);
