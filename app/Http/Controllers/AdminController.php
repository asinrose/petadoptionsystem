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

    public function products()
    {
        $products = \App\Models\Product::with('serviceProvider.user')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function orders()
    {
        $orders = \App\Models\Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function exportUsers()
    {
        $users = User::all();
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=users_report_' . date('Y-m-d') . '.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Status', 'Joined Date']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    ucfirst(str_replace('_', ' ', $user->role)),
                    ucfirst($user->status),
                    $user->created_at->format('Y-m-d')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive'
        ]);

        $user->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'User ' . $user->name . ' updated successfully!');
    }

    public function adoptions()
    {
        $adoptions = \App\Models\AdoptionRequest::with(['user', 'pet'])->latest()->paginate(10);
        return view('admin.adoptions', compact('adoptions'));
    }

    public function updateAdoptionStatus(\Illuminate\Http\Request $request, \App\Models\AdoptionRequest $request_obj)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected'
        ]);

        $request_obj->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Adoption request status updated successfully!');
    }
}


