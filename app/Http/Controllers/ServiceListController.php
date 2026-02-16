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

        if ($request->filled('date') && $request->filled('start_time') && $request->filled('end_time')) {
            $date = $request->date;
            $startTime = $request->start_time;
            $endTime = $request->end_time;

            // correct logic: Filter services where the provider is NOT booked in this time range
            $query->whereHas('provider', function ($q) use ($date, $startTime, $endTime) {
                $q->whereDoesntHave('serviceBookings', function ($b) use ($date, $startTime, $endTime) {
                        $b->where('date', $date)
                            ->where('status', '!=', 'cancelled')
                            ->where(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<', $endTime)
                            ->where('end_time', '>', $startTime);
                    }
                    );
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
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'pet_id' => 'required|exists:pets,id',
            'phone' => 'required|string',
            'address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $service = PetService::findOrFail($request->service_id);
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        // Double Booking Check (Time Range Overlap)
        // Existing booking overlaps if: (StartA < EndB) and (EndA > StartB)
        $exists = ServiceBooking::where('provider_id', $service->service_provider_id)
            ->where('date', $request->date)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
            $query->where('start_time', '<', $endTime)
                ->where('end_time', '>', $startTime);
        })
            ->exists();

        if ($exists) {
            return back()->with('error', 'The provider is not available during this time slot. Please choose another time.');
        }

        // Calculate Price based on duration in minutes
        $start = \Carbon\Carbon::parse($startTime);
        $end = \Carbon\Carbon::parse($endTime);
        $durationMinutes = $end->diffInMinutes($start);

        // Price per minute = (Service Price / Service Duration) OR simply assume Service Price is per hour?
        // User request: "confirm booking per hour the price should increase in total amount"
        // Interpretation: Service Price is likely "per service unit" (which might be 1 hour or fixed).
        // Let's assume the base price is per hour for now, or scale it.
        // If the service has a `duration_minutes` (e.g. 60), then `price` covers that duration.
        // Rate per minute = price / duration_minutes.
        // Total Price = Rate per minute * Booking Duration.

        $pricePerMinute = $service->price / ($service->duration_minutes ?: 60); // Avoid division by zero, default to 60 if null
        $totalPrice = $pricePerMinute * $durationMinutes;

        ServiceBooking::create([
            'user_id' => Auth::id(),
            'provider_id' => $service->service_provider_id,
            'service_id' => $service->id,
            'pet_id' => $request->pet_id,
            'date' => $request->date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'booked',
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,
            'total_price' => round($totalPrice, 2),
        ]);

        return redirect()->route('services.index')->with('success', 'Service booked successfully!');
    }
}
