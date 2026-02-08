<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pet;

class PetHomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::where('status', 'available');

        // Search by name or breed
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('breed', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter by location
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', "%{$request->location}%");
        }

        $pets = $query->latest()->get();

        return view('pethome', compact('pets'));
    }
}
