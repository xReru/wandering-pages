<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(10);
        $genres = Book::distinct()->pluck('genre');
        $inventoryLogs = InventoryLog::with(['book', 'order'])
            ->latest()
            ->paginate(20);

        return view('admin.books.index', compact('books', 'genres', 'inventoryLogs'));
    }

    public function create()
    {
        $genres = Genre::pluck('name');
        return view('admin.books.form', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                'unique:books,title',
                function ($attribute, $value, $fail) {
                    $trimmedTitle = trim($value);
                    $similarBook = Book::whereRaw('LOWER(title) = ?', [strtolower($trimmedTitle)])->first();
                    
                    if ($similarBook) {
                        $fail('A book with a similar title already exists. Please choose a different title.');
                    }
                }
            ],
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'is_active' => 'required|boolean'
        ]);

        $data = $request->all();
        $data['title'] = trim($data['title']); // Trim whitespace before saving

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        $genres = Genre::pluck('name');
        return view('admin.books.form', compact('book', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                'unique:books,title,' . $book->id,
                function ($attribute, $value, $fail) use ($book) {
                    $trimmedTitle = trim($value);
                    $similarBook = Book::whereRaw('LOWER(title) = ?', [strtolower($trimmedTitle)])
                        ->where('id', '!=', $book->id)
                        ->first();
                    
                    if ($similarBook) {
                        $fail('A book with a similar title already exists. Please choose a different title.');
                    }
                }
            ],
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'is_active' => 'required|boolean'
        ]);

        $data = $request->all();
        $data['title'] = trim($data['title']); // Trim whitespace before saving

        if ($request->hasFile('image')) {
            // Delete old image
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully.');
    }
} 