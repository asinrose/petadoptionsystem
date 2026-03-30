<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        if ($request->user()->role === 'service_provider') {
            return view('service_provider.profile.edit', [
                'user' => $request->user(),
            ]);
        }

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update name & email (Breeze default)
        $user->fill($request->validated());

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {

            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public_images')->delete($user->profile_photo);
            }

            // Store new photo
            $user->profile_photo =
                $request->file('profile_photo')->store('profile-photos', 'public_images');
        }

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('success', 'Profile updated successfully');
    }

    /**
     * Display the user's booked services.
     */
    public function bookedServices(Request $request): View
    {
        $bookings = $request->user()->serviceBookings()->with(['service', 'service.serviceProvider.user'])->latest()->get();

        return view('profile.booked_services', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->profile_photo) {
            Storage::disk('public_images')->delete($user->profile_photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
