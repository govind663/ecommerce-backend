<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::with('images')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'name.required' => 'Product name is required',
            'price.required' => 'Product price is required',
            'price.numeric' => 'Product price must be a number',
            'images.*.image' => 'Each file must be an image',
            'images.*.mimes' => 'Images must be of type jpg, jpeg, or png',
            'images.*.max' => 'Each image must not exceed 2MB'
        ]);

        $product = Product::create($request->only(['name', 'price']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $newName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('product_image'), $newName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'product_image/' . $newName,
                    ]);
                }
            }
        }

        return response()->json([
            [
                'status' => 200,
                'success' => true,
                'message' => 'Product created successfully',
                'product' => $product->load('images'),
            ]
        ]);
    }

}
