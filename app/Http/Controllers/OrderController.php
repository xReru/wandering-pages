<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
} 