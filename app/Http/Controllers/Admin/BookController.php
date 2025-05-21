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
        $books = Book::where('is_archived', false)
            ->latest()
            ->paginate(10);
        $genres = Book::distinct()->pluck('genre');
        $inventoryLogs = InventoryLog::with(['book', 'order'])
            ->latest()
            ->paginate(20);

        return view('admin.books.index', compact('books', 'genres', 'inventoryLogs'));
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
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

        // Automatically set is_active to false if quantity is 0
        if ($data['quantity'] <= 0) {
            $data['is_active'] = false;
        }
        if ($data['quantity'] > 0) {
            $data['is_active'] = true;
        }
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

    public function archived()
    {
        $archivedBooks = Book::where('is_archived', true)
            ->orderBy('archived_at', 'desc')
            ->paginate(10);

        return view('admin.books.archive', compact('archivedBooks'));
    }

    public function archive(Book $book)
    {
        $book->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book has been archived successfully.');
    }

    public function restore(Book $book)
    {
        $book->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);

        return redirect()->route('admin.books.archive')
            ->with('success', 'Book has been restored successfully.');
    }

    public function permanentDelete(Book $book)
    {
        // Only allow permanent deletion of archived books
        if (!$book->is_archived) {
            return redirect()->route('admin.books.archive')
                ->with('error', 'Only archived books can be permanently deleted.');
        }

        // Delete the book's image if it exists
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        // Delete associated records
        $book->ratings()->delete();
        $book->likes()->delete();
        $book->inventoryLogs()->delete();

        // Delete the book
        $book->delete();

        return redirect()->route('admin.books.archived')
            ->with('success', 'Book has been permanently deleted.');
    }
} 