<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/browse-books', function () {
    return view('browse-books');
});
