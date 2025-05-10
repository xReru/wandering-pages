<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\ShoppingCart;

class CartController extends Controller
{
    // Get the current user's cart (for modal display)
    public function getCart()
    {
        try {
            $user = Auth::guard('customer')->user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $cart = $user->cart()->with('items.book')->first();
            if (!$cart) {
                $cart = $user->cart()->create();
            }

            return response()->json($cart);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch cart'], 500);
        }
    }

    // Add a book to the cart
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'quantity' => 'nullable|integer|min:1'
            ]);

            $user = Auth::guard('customer')->user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $cart = $user->cart ?: $user->cart()->create();

            $item = $cart->items()->where('book_id', $request->book_id)->first();
            if ($item) {
                $item->quantity += $request->input('quantity', 1);
                $item->save();
            } else {
                $cart->items()->create([
                    'book_id' => $request->book_id,
                    'quantity' => $request->input('quantity', 1)
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add item to cart'], 500);
        }
    }

    // Update the quantity of a cart item
    public function updateCartItem(Request $request, CartItem $item)
    {
        try {
            $user = Auth::guard('customer')->user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Check if the item belongs to the user's cart
            if ($item->cart->user_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $request->validate(['quantity' => 'required|integer|min:1']);
            $item->quantity = $request->quantity;
            $item->save();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update cart item: ' . $e->getMessage()], 500);
        }
    }

    // Remove an item from the cart
    public function removeFromCart(CartItem $item)
    {
        try {
            $user = Auth::guard('customer')->user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Check if the item belongs to the user's cart
            if ($item->cart->user_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $item->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to remove item from cart: ' . $e->getMessage()], 500);
        }
    }
}
