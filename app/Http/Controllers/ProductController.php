<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::active()
            ->with(['category', 'variants'])
            ->paginate(10);

        return view('products.index', compact('products'));
    }
}
