<?php

namespace App\Http\Controllers;

use App\Models\BannerSlide;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bannerSlides = BannerSlide::with('book')
            ->where('status', 'active')
            ->whereHas('book', function($query) {
                $query->where('is_active', true);
            })
            ->orderBy('order')
            ->get();

        $books = Book::latest()->take(8)->get();
        $bestSellers = app(BookController::class)->getBestSellers();

        return view('home', compact('bannerSlides', 'books', 'bestSellers'));
    }
} 