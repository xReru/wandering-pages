<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

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

        return view('browse-books', [
            'books' => $books,
            'genres' => $genres,
            'selectedGenre' => $genre ?? 'All',
            'selectedSort' => $sort,
            'promoBooks' => $promoBooks,
        ]);
    }
}
