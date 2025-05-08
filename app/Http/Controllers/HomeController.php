<?php

namespace App\Http\Controllers;

use App\Models\BannerSlide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bannerSlides = BannerSlide::where('status', 'active')
            ->orderBy('order')
            ->get();

        return view('home', compact('bannerSlides'));
    }
} 