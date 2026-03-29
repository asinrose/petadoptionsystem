<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pet;
use App\Models\AdoptionRequest;

class AdoptionController extends Controller
{
    public function store(Request $request, $petId)
    {
        $pet = Pet::findOrFail($petId);

        // Prevent owner from adopting their own pet
        if ($pet->user_id === auth()->id()) {
            return back()->with('error', 'You cannot adopt your own pet.');
        }

        // Check if already requested
        $existingRequest = AdoptionRequest::where('user_id', auth()->id())
            ->where('pet_id', $pet->id)
            ->first();

        if ($existingRequest) {
            return back()->with('info', 'You have already requested to adopt this pet.');
        }

        AdoptionRequest::create([
            'user_id' => auth()->id(),
            'pet_id' => $pet->id,
            'status' => 'pending',
            'request_date' => now(),
        ]);

        return back()->with('success', 'Adoption request sent successfully!');
    }

    public function applications()
    {
        // Fetch all adoption requests where the pet belongs to the authenticated user
        $applications = AdoptionRequest::whereHas('pet', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->with('pet', 'user') // eager load related models
            ->latest()
            ->get();

        return view('profile.applications', compact('applications'));
    }

    public function updateStatus(Request $request, AdoptionRequest $application)
    {
        // Ensure the logged-in user owns the pet being applied for
        if ($application->pet->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Application status successfully updated to ' . $request->status . '.');
    }

    public function bookedPets()
    {
        // Fetch adoption requests made by the logged-in user
        $applications = AdoptionRequest::where('user_id', auth()->id())
            ->with(['pet', 'pet.user'])
            ->latest()
            ->get();

        return view('profile.booked_pets', compact('applications'));
    }
}

