<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        $cartItems = $request->cart;

        foreach ($cartItems as $item) {
            $product = Product::find($item['id']);
            
            // prevent ordering more than available stock
            if ($product->stock >= $item['quantity']) {
                Order::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'total_price' => $product->price * $item['quantity'],
                    'status' => 'Pending',
                ]);

                // decrement
                $product->decrement('stock', $item['quantity']);
            }
        }

        return redirect()->route('welcome')->with('success', 'Order placed successfully!');
    }
}