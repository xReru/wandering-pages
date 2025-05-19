<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerSlide;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerSlideController extends Controller
{
    public function index()
    {
        $slides = BannerSlide::with('book')->orderBy('order')->get();
        return view('admin.banner-slides.index', compact('slides'));
    }

    public function create()
    {
        $books = Book::where('is_active', true)->get();
        return view('admin.banner-slides.form', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'type' => 'required|in:new_release,bestseller,coming_soon',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer|min:0',
        ]);

        BannerSlide::create($validated);

        return redirect()
            ->route('admin.banner-slides.index')
            ->with('success', 'Banner slide created successfully.');
    }

    public function edit(BannerSlide $bannerSlide)
    {
        $books = Book::where('is_active', true)->get();
        return view('admin.banner-slides.form', ['slide' => $bannerSlide, 'books' => $books]);
    }

    public function update(Request $request, BannerSlide $bannerSlide)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'type' => 'required|in:new_release,bestseller,coming_soon',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer|min:0',
        ]);

        $bannerSlide->update($validated);

        return redirect()
            ->route('admin.banner-slides.index')
            ->with('success', 'Banner slide updated successfully.');
    }

    public function destroy(BannerSlide $bannerSlide)
    {
        $bannerSlide->delete();

        return redirect()
            ->route('admin.banner-slides.index')
            ->with('success', 'Banner slide deleted successfully.');
    }
} 