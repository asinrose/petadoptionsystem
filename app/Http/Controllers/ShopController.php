<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Product::where('is_active', true)->where('stock', '>', 0);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(12);
        return view('shop.index', compact('products'));
    }

    public function show(\App\Models\Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        return view('shop.show', compact('product'));
    }
}
