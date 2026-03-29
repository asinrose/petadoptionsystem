<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceProviderDashboardController extends Controller
{
    public function index()
    {
        $provider = auth()->user()->serviceProvider;

        if (!$provider) {
            return view('service_provider.dashboard', [
                'totalServices' => 0,
                'pendingRequests' => 0,
                'totalBookings' => 0,
                'recentBookings' => collect()
            ]);
        }

        $totalServices = $provider->services()->count();
        // Bookings that are just created have 'booked' status, meaning pending provider action
        $pendingRequests = $provider->serviceBookings()->where('status', 'booked')->count();
        $totalBookings = $provider->serviceBookings()->count();
        $recentBookings = $provider->serviceBookings()->with(['user', 'service'])->latest()->take(5)->get();

        return view('service_provider.dashboard', compact(
            'totalServices',
            'pendingRequests',
            'totalBookings',
            'recentBookings'
        ));
    }

    public function confirmBooking(\App\Models\ServiceBooking $booking)
    {
        $provider = auth()->user()->serviceProvider;

        // Ensure the provider owns this booking
        if (!$provider || $booking->provider_id !== $provider->id) {
            abort(403, 'Unauthorized action.');
        }

        $booking->update([
            'status' => 'confirmed'
        ]);

        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }
    public function schedule()
    {
        $provider = auth()->user()->serviceProvider;
        
        if (!$provider) {
            return redirect()->route('service-provider.dashboard')->with('error', 'Provider profile not found.');
        }

        // Fetch upcoming bookings (status pending or confirmed)
        $bookings = $provider->serviceBookings()
            ->with(['user', 'service'])
            ->whereIn('status', ['booked', 'confirmed'])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('service_provider.schedule', compact('bookings'));
    }
}
