<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\InventoryLog;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $lowStockBooks = Book::where('quantity', '<=', 5)->get();
        $inventoryLogs = InventoryLog::with(['book', 'order'])
            ->latest()
            ->paginate(20);

        return view('admin.inventory.index', compact('lowStockBooks', 'inventoryLogs'));
    }

    public function getLowStockAlerts()
    {
        $lowStockBooks = Book::where('quantity', '<=', 5)
            ->select('id', 'title', 'quantity', 'price')
            ->get();

        return response()->json([
            'count' => $lowStockBooks->count(),
            'books' => $lowStockBooks
        ]);
    }
} 