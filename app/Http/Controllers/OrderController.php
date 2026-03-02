<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $cartItems = \App\Models\Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Create Order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
        ]);

        // Create Order Items and Reduce Stock
        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Reduce stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear Cart
        \App\Models\Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('profile.orders')->with('success', 'Order placed successfully!');
    }

    public function userOrders()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())->with('orderItems.product')->latest()->get();
        return view('profile.orders', compact('orders'));
    }
}
