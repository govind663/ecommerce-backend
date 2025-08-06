<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'name.required' => 'Product name is required',
            'price.required' => 'Product price is required',
            'price.numeric' => 'Product price must be a number',
            'images.*.required' => 'At least one product image is required',
            'images.*.image' => 'Each file must be an image',
            'images.*.mimes' => 'Images must be of type jpg, jpeg, or png',
            'images.*.max' => 'Each image must not exceed 2MB'
        ]);

        $product = Product::create($request->only(['name', 'price']));

        // Initialize array to store image paths
        $imagePaths = [];

        // Check if new images are uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    // Generate a unique file name
                    $newName = Str::uuid() . '.' . $image->getClientOriginalExtension();

                    // Move the image to the public/product_image directory
                    $image->move(public_path('product_image'), $newName);

                    // Save image path in the database
                    ProductImage::create([
                        'product_id' => $product->id, // ensure $product is defined
                        'image_path' => 'product_image/' . $newName,
                    ]);

                    // Optionally store the path in array
                    $imagePaths[] = $newName;
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }
}
