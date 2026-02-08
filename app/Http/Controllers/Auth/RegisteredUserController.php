<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // ✅ ROLE FROM CHECKBOX
            'role' => $request->has('is_service_provider')
            ? 'service_provider'
            : 'user',
        ]);

        if ($user->role === 'service_provider') {
            $user->serviceProvider()->create([
                'service_type' => 'General', // Default value
                'verification_status' => 'pending',
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        // ✅ ROLE-BASED REDIRECT AFTER REGISTER
        if ($user->role === 'service_provider') {
            return redirect()->route('service-provider.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}
