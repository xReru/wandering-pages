<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $cart = $user->cart()->with('items.book')->first();
        return view('customers.order.order-checkout', [
            'cart' => $cart,
            'user' => $user
        ]);
    }

    public function index()
    {
        $user = Auth::guard('customer')->user();
        $orders = $user->orders()->with('items.book')->latest()->get();
        return view('customers.order.index', [
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        $order->load(['items.book', 'user']);
        return view('customers.order.show', [
            'order' => $order
        ]);
    }

    
    public function submitOrder(Request $request)
    {
        $request->validate([
            'transaction_no' => 'required|string',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'selected_items' => 'required|json'
        ]);

        $user = Auth::guard('customer')->user();
        $cart = $user->cart()->with('items.book')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        try {
            DB::beginTransaction();

            // Get selected items from request
            $selectedItems = json_decode($request->selected_items, true);
            if (empty($selectedItems)) {
                return response()->json(['error' => 'No items selected for checkout'], 400);
            }

            // Calculate shipping fee
            $shippingFee = $request->shipping_method === 'express' ? 50 : 20;
            
            // Calculate total amount for selected items only
            $subtotal = collect($selectedItems)->sum(function ($item) {
                return $item['book']['price'] * $item['quantity'];
            });
            $totalAmount = $subtotal + $shippingFee;

            // Handle payment proof upload
            $paymentProof = $request->file('payment_proof');
            $paymentProofPath = $paymentProof->store('payment_proofs', 'public');

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'transaction_no' => $request->transaction_no,
                'total_amount' => $totalAmount,
                'shipping_fee' => $shippingFee,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'payment_proof' => $paymentProofPath,
                'status' => 'pending',
                'shipping_address' => $user->address
            ]);

            // Create order items for selected items only
            foreach ($selectedItems as $selectedItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $selectedItem['book']['id'],
                    'quantity' => $selectedItem['quantity'],
                    'price_at_time_of_order' => $selectedItem['book']['price']
                ]);

                // Remove the selected item from cart
                $cart->items()->where('book_id', $selectedItem['book']['id'])->delete();
            }

            // If cart is empty after removing selected items, delete the cart
            if ($cart->items()->count() === 0) {
                $cart->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to place order: ' . $e->getMessage()], 500);
        }
    }

    public function pending()
    {
        \Log::info('Accessing pending orders page');
        try {
            $user = Auth::guard('customer')->user();
            \Log::info('User authenticated', ['user_id' => $user->id]);
            
            $orders = $user->orders()->with('items.book')->whereIn('status', ['pending', 'paid'])->latest()->get();
            \Log::info('Orders retrieved', ['count' => $orders->count()]);
            
            return view('customers.order.pending', [
                'orders' => $orders
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in pending orders', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function shipping()
    {
        \Log::info('Accessing shipping orders page');
        try {
            $user = Auth::guard('customer')->user();
            \Log::info('User authenticated', ['user_id' => $user->id]);
            
            $orders = $user->orders()->with('items.book')->where('status', 'shipping')->latest()->get();
            \Log::info('Orders retrieved', ['count' => $orders->count()]);
            
            return view('customers.order.shipping', [
                'orders' => $orders
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in shipping orders', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function delivering()
    {
        \Log::info('Accessing delivering orders page');
        try {
            $user = Auth::guard('customer')->user();
            \Log::info('User authenticated', ['user_id' => $user->id]);
            
            $orders = $user->orders()->with('items.book')->where('status', 'delivering')->latest()->get();
            \Log::info('Orders retrieved', ['count' => $orders->count()]);
            
            return view('customers.order.delivering', [
                'orders' => $orders
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in delivering orders', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function completed()
    {
        \Log::info('Accessing completed orders page');
        try {
            $user = Auth::guard('customer')->user();
            \Log::info('User authenticated', ['user_id' => $user->id]);
            
            $orders = $user->orders()->with('items.book')->where('status', 'completed')->latest()->get();
            \Log::info('Orders retrieved', ['count' => $orders->count()]);
            
            return view('customers.order.rating', [
                'orders' => $orders
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in completed orders', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Show the order history page with tabs for completed, cancelled, and return/refund orders.
     */
    public function history()
    {
        $user = Auth::guard('customer')->user();
        $completedOrders = $user->orders()->with('items.book')->where('status', 'completed')->latest()->get();
        $cancelledOrders = $user->orders()->with('items.book')->where('status', 'cancelled')->latest()->get();
        $refundedOrders = $user->orders()->with('items.book')->whereIn('status', ['refunded', 'return', 'returned'])->latest()->get();
        return view('customers.history', compact('completedOrders', 'cancelledOrders', 'refundedOrders'));
    }

    public function cancel(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::guard('customer')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Check if the order can be cancelled
        if (!in_array($order->status, ['pending', 'paid'])) {
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be cancelled'
            ], 422);
        }

        try {
            $order->update(['status' => 'cancelled']);
            
            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order'
            ], 500);
        }
    }
} 