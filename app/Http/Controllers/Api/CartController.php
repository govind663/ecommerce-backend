<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = Cart::create([
            'user_id' => 1, // hardcoded
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart' => $cart
        ]);
    }

    public function getCartItems()
    {
        $cart = Cart::with('product.images')->where('user_id', 1)->get();
        return response()->json($cart);
    }

    
}
