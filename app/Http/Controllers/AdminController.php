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
}
