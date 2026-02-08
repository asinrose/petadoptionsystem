<?php

namespace App\Http\Controllers;

use App\Models\PetService;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceListController extends Controller
{
    public function index(Request $request)
    {
        $query = PetService::with('provider.user');

        if ($request->filled('service_type')) {
            $query->where('name', 'like', '%' . $request->service_type . '%');
        }

        if ($request->filled('date') && $request->filled('time')) {
            $date = $request->date;
            $time = $request->time;

            // correct logic: Filter services where the provider is NOT booked at this time
            $query->whereHas('provider', function ($q) use ($date, $time) {
                $q->whereDoesntHave('serviceBookings', function ($b) use ($date, $time) {
                        $b->where('date', $date)
                            ->where('time', $time)
                            ->where('status', '!=', 'cancelled');
                    }
                    );
                });
        }

        $services = $query->latest()->paginate(9);
        $serviceTypes = PetService::select('name')->distinct()->pluck('name');
        $pets = Auth::check() ?Auth::user()->pets : [];

        return view('services.index', compact('services', 'serviceTypes', 'pets'));
    }

    public function book(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:pet_services,id',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'pet_id' => 'required|exists:pets,id',
        ]);

        $service = PetService::findOrFail($request->service_id);

        // Double Booking Check
        $exists = ServiceBooking::where('provider_id', $service->service_provider_id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->with('error', 'This slot is already booked. Please choose another time.');
        }

        ServiceBooking::create([
            'user_id' => Auth::id(),
            'provider_id' => $service->service_provider_id,
            'service_id' => $service->id,
            'pet_id' => $request->pet_id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'booked',
        ]);

        return redirect()->route('services.index')->with('success', 'Service booked successfully!');
    }
}
