<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')
                      ->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function welcome()
    {
        $products = Product::where('is_active', true)
                      ->orderBy('created_at', 'desc')
                      ->take(4)
                      ->get();
        return view('welcome', compact('products'));
    }
}