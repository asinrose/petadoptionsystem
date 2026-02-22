<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pet;

class FavoriteController extends Controller
{
    public function toggle(Pet $pet)
    {
        $user = auth()->user();

        if ($user->favorites()->where('pet_id', $pet->id)->exists()) {
            $user->favorites()->detach($pet->id);
            $message = 'Removed from favorites.';
        }
        else {
            $user->favorites()->attach($pet->id);
            $message = 'Added to favorites.';
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $favorites = auth()->user()->favorites()->latest()->get();

        return view('profile.favorites', compact('favorites'));
    }
}
