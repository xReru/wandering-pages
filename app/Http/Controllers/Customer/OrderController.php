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
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::guard('customer')->user();
        $cart = $user->cart()->with('items.book')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        try {
            DB::beginTransaction();

            // Calculate shipping fee
            $shippingFee = $request->shipping_method === 'express' ? 50 : 20;
            
            // Calculate total amount
            $subtotal = $cart->items->sum(function ($item) {
                return $item->book->price * $item->quantity;
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

            // Create order items
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $cartItem->book_id,
                    'quantity' => $cartItem->quantity,
                    'price_at_time_of_order' => $cartItem->book->price
                ]);
            }

            // Clear the cart
            $cart->items()->delete();
            $cart->delete();

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
            
            $orders = $user->orders()->with('items.book')->where('status', 'pending')->latest()->get();
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
            
            return view('customers.order.completed', [
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
} 