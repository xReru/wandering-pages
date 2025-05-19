<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    
    public function index(Request $request)
    {   
        $promoBooks = [
            [
                'title' => 'Before the Darkest Hour',
                'author' => 'Brenna Harlow',
                'image' => 'images/before-the-darkest-hour.png',
                'rotate' => '-rotate-0'
            ],
            [
                'title' => 'Blood at Dusk',
                'author' => 'Brenna Harlow',
                'image' => 'images/blood-at-dusk.png',
                'rotate' => 'rotate-0'
            ],
            [
                'title' => 'Blood After Dawn',
                'author' => 'Brenna Harlow',
                'image' => 'images/blood-after-dawn.png',
                'rotate' => '-rotate-0'
            ],
            [
                'title' => 'Blood follows Midnight',
                'author' => 'Brenna Harlow',
                'image' => 'images/blood-follows-midnight.png',
                'rotate' => 'rotate-0'
            ],
            [
                'title' => 'Blood before Sunrise',
                'author' => 'Brenna Harlow',
                'image' => 'images/blood-before-sunrise.png',
                'rotate' => 'rotate-0'
            ],
        ];
        $query = Book::query();

        // Only show active books
        $query->where('is_active', true);

        // Filtering by genre
        $genre = $request->input('genre');
        if ($genre && $genre !== 'All') {
            $query->where('genre', $genre);
        }

        // Sorting
        $sort = $request->input('sort', 'best_selling');
        if ($sort === 'best_selling') {
            $query->orderByDesc('id'); // Placeholder for best selling
        } elseif ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        // Pagination
        $books = $query->paginate(10)->withQueryString();

        // Get all genres for filter dropdown
        $genres = Book::select('genre')->distinct()->pluck('genre')->toArray();
        array_unshift($genres, 'All');

        // Get best sellers
        $bestSellers = $this->getBestSellers();

        return view('browse-books', [
            'books' => $books,
            'genres' => $genres,
            'selectedGenre' => $genre ?? 'All',
            'selectedSort' => $sort,
            'promoBooks' => $promoBooks,
            'bestSellers' => $bestSellers,
        ]);
    }

    public function show($id)
    {
        $book = Book::where('is_active', true)->findOrFail($id);
        // Fetch related books by genre, excluding the current book
        $relatedBooks = Book::where('genre', $book->genre)
            ->where('id', '!=', $book->id)
            ->where('is_active', true)
            ->limit(8)
            ->get();
        $liked = false;
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $liked = Like::where('customer_id', $customer->id)
                ->where('book_id', $book->id)
                ->exists();
        }
        // Load paginated ratings
        $ratings = $book->ratings()->with('user')->latest()->paginate(5);
        return view('book-details', compact('book', 'relatedBooks', 'liked', 'ratings'));
    }

    public function getBestSellers()
    {
        $bestSellers = Book::select('books.*')
            ->join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->where('books.is_active', true)
            ->groupBy('books.id')
            ->orderByRaw('SUM(order_items.quantity) DESC')
            ->limit(6)
            ->get();

        return $bestSellers;
    }
}
