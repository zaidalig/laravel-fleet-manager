<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::with(['vehicle', 'driver']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->input('driver_id'));
        }

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->input('vehicle_id'));
        }

        if ($request->filled('date')) {
            $query->whereDate('started_at', $request->input('date'));
        }

        $trips = $query->latest('started_at')->paginate(10)->withQueryString();
        $drivers = Driver::where('status', 'active')->orderBy('name')->get();
        $vehicles = Vehicle::orderBy('plate_number')->get();

        return view('trips.index', compact('trips', 'drivers', 'vehicles'));
    }

    public function create()
    {
        $drivers = Driver::where('status', 'active')->orderBy('name')->get();
        $vehicles = Vehicle::whereIn('status', ['available', 'in_use'])->orderBy('plate_number')->get();

        return view('trips.create', compact('drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_location' => 'required|string|max:255',
            'end_location' => 'required|string|max:255',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'distance_km' => 'nullable|numeric|min:0',
            'purpose' => 'nullable|string|max:255',
            'status' => 'required|in:planned,in_progress,completed,cancelled',
        ]);

        $next = (Trip::max('id') ?? 0) + 1;
        $data['trip_number'] = 'TRP-'.str_pad((string) $next, 5, '0', STR_PAD_LEFT);
        $data['distance_km'] = $data['distance_km'] ?? 0;
        $data['user_id'] = $request->user()->id;

        $trip = Trip::create($data);

        if ($trip->status === 'in_progress') {
            $trip->vehicle->update(['status' => 'in_use']);
        }

        return redirect()->route('trips.show', $trip)
            ->with('success', "Trip {$trip->trip_number} created.");
    }

    public function show(Trip $trip)
    {
        $trip->load(['vehicle', 'driver', 'user', 'fuelLogs']);

        return view('trips.show', compact('trip'));
    }

    public function updateStatus(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'status' => 'required|in:planned,in_progress,completed,cancelled',
            'ended_at' => 'nullable|date',
            'distance_km' => 'nullable|numeric|min:0',
        ]);

        if (isset($data['ended_at'])) {
            $trip->ended_at = $data['ended_at'];
        } elseif (in_array($data['status'], ['completed', 'cancelled'], true) && ! $trip->ended_at) {
            $trip->ended_at = now();
        }

        if (array_key_exists('distance_km', $data) && $data['distance_km'] !== null) {
            $trip->distance_km = $data['distance_km'];
        }

        $trip->status = $data['status'];
        $trip->save();

        if ($trip->status === 'in_progress') {
            $trip->vehicle->update(['status' => 'in_use']);
        } elseif (in_array($trip->status, ['completed', 'cancelled'], true)) {
            $trip->vehicle->update(['status' => 'available']);
        }

        return back()->with('success', 'Trip status updated.');
    }
}
