<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetController extends Controller
{
    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'contact' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'type' => 'required|string|in:dog,cat,bird,other',
            'weight' => 'nullable|string|max:255',
            'vaccination_status' => 'required|in:vaccinated,not_vaccinated',
            'vaccination_date' => 'nullable|date',
            'dewormed' => 'required|boolean',
            'medical_conditions' => 'nullable|string',
            'special_care_requirements' => 'nullable|string',
            'adoption_type' => 'required|in:free,fee',
            'adoption_fee' => 'nullable|numeric|min:0',
        ]);

        $imagePath = $request->file('image')->store('pets', 'public');

        \App\Models\Pet::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'breed' => $request->breed,
            'age' => $request->age,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'location' => $request->location,
            'image' => $imagePath,
            'description' => $request->description,
            'type' => $request->type,
            'status' => 'available',
            'weight' => $request->weight,
            'vaccination_status' => $request->vaccination_status,
            'vaccination_date' => $request->vaccination_date,
            'dewormed' => $request->dewormed,
            'medical_conditions' => $request->medical_conditions,
            'special_care_requirements' => $request->special_care_requirements,
            'adoption_type' => $request->adoption_type,
            'adoption_fee' => $request->adoption_fee,
        ]);

        return redirect()->route('pethome')->with('success', 'Pet posted successfully!');
    }

    public function show(\App\Models\Pet $pet)
    {
        return view('pets.show', compact('pet'));
    }

    public function myPets()
    {
        $pets = \App\Models\Pet::where('user_id', auth()->id())->latest()->get();
        return view('pets.my_pets', compact('pets'));
    }

    public function destroy(\App\Models\Pet $pet)
    {
        if ($pet->user_id !== auth()->id()) {
            abort(403);
        }

        if ($pet->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pet->image);
        }

        $pet->delete();

        return back()->with('success', 'Pet removed successfully.');
    }
}
