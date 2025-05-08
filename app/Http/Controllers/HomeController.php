<?php

namespace App\Http\Controllers;

use App\Models\BannerSlide;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bannerSlides = BannerSlide::where('status', 'active')
            ->orderBy('order')
            ->get();

        $books = Book::latest()->take(8)->get();

        return view('home', compact('bannerSlides', 'books'));
    }
} 