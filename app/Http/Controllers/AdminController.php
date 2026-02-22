<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pet;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalServiceProviders = User::where('role', 'service_provider')->count();
        $totalPets = Pet::count();
        $adoptedPets = Pet::where('status', 'adopted')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalServiceProviders', 'totalPets', 'adoptedPets'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function pets()
    {
        $pets = Pet::with('user')->latest()->paginate(10);
        return view('admin.pets', compact('pets'));
    }

    public function destroyPet(Pet $pet)
    {
        $pet->delete();
        return redirect()->back()->with('success', 'Pet listing removed successfully!');
    }

    public function updatePetStatus(\Illuminate\Http\Request $request, Pet $pet)
    {
        $request->validate([
            'status' => 'required|string|in:Available,Adopted,Lost,Found'
        ]);

        $pet->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Pet status updated successfully!');
    }
}
