<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Books::query();

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
        $genres = Books::select('genre')->distinct()->pluck('genre')->toArray();
        array_unshift($genres, 'All');

        return view('browse-books', [
            'books' => $books,
            'genres' => $genres,
            'selectedGenre' => $genre ?? 'All',
            'selectedSort' => $sort,
        ]);
    }
}
