<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerSlideController extends Controller
{
    public function index()
    {
        $slides = BannerSlide::orderBy('order')->get();
        return view('admin.banner-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.banner-slides.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:new_release,bestseller,coming_soon',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer|min:0',
            'button_text' => 'required|string|max:255',
            'button_link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banner-slides', 'public');
            $validated['image_path'] = $path;
        }

        BannerSlide::create($validated);

        return redirect()
            ->route('admin.banner-slides.index')
            ->with('success', 'Banner slide created successfully.');
    }

    public function edit(BannerSlide $bannerSlide)
    {
        return view('admin.banner-slides.form', ['slide' => $bannerSlide]);
    }

    public function update(Request $request, BannerSlide $bannerSlide)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:new_release,bestseller,coming_soon',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer|min:0',
            'button_text' => 'required|string|max:255',
            'button_link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($bannerSlide->image_path) {
                Storage::disk('public')->delete($bannerSlide->image_path);
            }
            $path = $request->file('image')->store('banner-slides', 'public');
            $validated['image_path'] = $path;
        }

        $bannerSlide->update($validated);

        return redirect()
            ->route('admin.banner-slides.index')
            ->with('success', 'Banner slide updated successfully.');
    }

    public function destroy(BannerSlide $bannerSlide)
    {
        if ($bannerSlide->image_path) {
            Storage::disk('public')->delete($bannerSlide->image_path);
        }
        
        $bannerSlide->delete();

        return redirect()
            ->route('admin.banner-slides.index')
            ->with('success', 'Banner slide deleted successfully.');
    }
} 