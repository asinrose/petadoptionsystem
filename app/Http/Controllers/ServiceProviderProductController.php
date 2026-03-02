<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceProviderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provider = auth()->user()->serviceProvider;
        if (!$provider) {
            $provider = auth()->user()->serviceProvider()->create([
                'service_type' => 'General',
                'verification_status' => 'pending'
            ]);
        }
        $products = $provider->products ?? collect(); // assuming relationship exists
        // Wait, I need to add products relationship to ServiceProvider model

        return view('service_provider.products.index', compact('products'));
    }

    public function create()
    {
        return view('service_provider.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $provider = auth()->user()->serviceProvider;
        // Need to use eloquent relationship or create directly
        \App\Models\Product::create([
            'service_provider_id' => $provider->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('service-provider.products.index')->with('success', 'Product created successfully.');
    }

    public function show(string $id)
    {
    //
    }

    public function edit(string $id)
    {
        $product = \App\Models\Product::where('service_provider_id', auth()->user()->serviceProvider->id)->findOrFail($id);
        return view('service_provider.products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = \App\Models\Product::where('service_provider_id', auth()->user()->serviceProvider->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Delete old image if needed, for simplicity just overwrite path
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('service-provider.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        $product = \App\Models\Product::where('service_provider_id', auth()->user()->serviceProvider->id)->findOrFail($id);
        $product->delete();
        return redirect()->route('service-provider.products.index')->with('success', 'Product deleted successfully.');
    }
}
