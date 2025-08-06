<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $userId = 1;

        $existingCart = Cart::where('user_id', $userId)
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($existingCart) {
            return response()->json([
                [
                    'success' => false,
                    'message' => 'Product is already in the cart',
                    'cart' => $existingCart
                ]
            ], 409); // 409 Conflict
        }

        $cart = Cart::create([
            'user_id' => $userId,
            'product_id' => $request->product_id
        ]);

        return response()->json([
            [
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart' => $cart
            ]
        ]);
    }

    public function getCartItems()
    {
        $cart = Cart::with('product.images')->where('user_id', 1)->get();
        return response()->json($cart);
    }

}
