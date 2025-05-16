<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Show all liked books for the authenticated customer
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $likes = Like::with('book')
            ->where('customer_id', $customer->id)
            ->get();
        return view('customers.likes', compact('likes', 'customer'));
    }

    // Like a book
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);
        $customer = Auth::guard('customer')->user();
        $like = Like::firstOrCreate([
            'customer_id' => $customer->id,
            'book_id' => $request->book_id,
        ]);
        return response()->json(['success' => true, 'liked' => true]);
    }

    // Unlike a book
    public function destroy(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);
        $customer = Auth::guard('customer')->user();
        $deleted = Like::where('customer_id', $customer->id)
            ->where('book_id', $request->book_id)
            ->delete();
        return response()->json(['success' => $deleted > 0, 'liked' => false]);
    }
}
