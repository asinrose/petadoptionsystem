<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceProviderServiceController extends Controller
{
    public function index()
    {
        $provider = auth()->user()->serviceProvider;

        if (!$provider) {
            // Fallback: Create the record if it doesn't exist (self-healing)
            $provider = auth()->user()->serviceProvider()->create([
                'service_type' => 'General',
                'verification_status' => 'pending'
            ]);
        }

        $services = $provider->services;
        return view('service_provider.services.index', compact('services'));
    }

    public function create()
    {
        return view('service_provider.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        auth()->user()->serviceProvider->services()->create($request->all());

        return redirect()->route('service-provider.services.index')
            ->with('success', 'Service added successfully.');
    }
}
