<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.book'])
            ->latest()
            ->paginate(10);
            
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.book']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,paid,shipped,delivered,cancelled'
            ]);

            // Define valid status transitions
            $validTransitions = [
                'pending' => ['paid', 'cancelled'],
                'paid' => ['shipped', 'cancelled'],
                'shipped' => ['delivered', 'cancelled'],
                'delivered' => [],
                'cancelled' => []
            ];

            // Check if the status transition is valid
            if (!in_array($request->status, $validTransitions[$order->status])) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot change status from '{$order->status}' to '{$request->status}'"
                ], 422);
            }

            // Update the order status
            $order->update([
                'status' => $request->status
            ]);

            // Log the status change
            Log::info('Order status updated', [
                'order_id' => $order->id,
                'transaction_no' => $order->transaction_no,
                'old_status' => $order->getOriginal('status'),
                'new_status' => $request->status,
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'transaction_no' => $order->transaction_no
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update order status', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status: ' . $e->getMessage()
            ], 500);
        }
    }
} 