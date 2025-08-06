<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = Cart::with('product.images')->where('user_id', 1)->get();
        return view('cart.index', compact('cartItems'));
    }
}
