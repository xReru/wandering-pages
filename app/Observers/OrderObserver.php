<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Check if the status was changed to completed
        if ($order->isDirty('status') && $order->status === 'completed') {
            // Use a transaction to ensure data consistency
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $book = Book::find($item->book_id);
                    if ($book) {
                        // Decrease the inventory
                        $book->decrement('quantity', $item->quantity);
                        
                        // Log the inventory change
                        DB::table('inventory_logs')->insert([
                            'book_id' => $book->id,
                            'quantity_change' => -$item->quantity,
                            'type' => 'order_completed',
                            'reference_id' => $order->id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            });
        }
    }
} 