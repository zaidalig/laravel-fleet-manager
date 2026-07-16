<?php

namespace App\Http\Controllers;

use App\Models\FuelLog;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FuelLogController extends Controller
{
    public function index(Request $request)
    {
        $query = FuelLog::with(['vehicle', 'trip']);

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->input('vehicle_id'));
        }

        if ($request->filled('from')) {
            $query->whereDate('fueled_at', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('fueled_at', '<=', $request->input('to'));
        }

        $fuelLogs = $query->latest('fueled_at')->paginate(10)->withQueryString();
        $vehicles = Vehicle::orderBy('plate_number')->get();

        return view('fuel-logs.index', compact('fuelLogs', 'vehicles'));
    }

    public function create()
    {
        $vehicles = Vehicle::orderBy('plate_number')->get();
        $trips = Trip::with('vehicle')->latest('started_at')->limit(50)->get();

        return view('fuel-logs.create', compact('vehicles', 'trips'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        FuelLog::create($data);

        return redirect()->route('fuel-logs.index')->with('success', 'Fuel log recorded.');
    }

    public function edit(FuelLog $fuelLog)
    {
        $vehicles = Vehicle::orderBy('plate_number')->get();
        $trips = Trip::with('vehicle')->latest('started_at')->limit(50)->get();

        return view('fuel-logs.edit', compact('fuelLog', 'vehicles', 'trips'));
    }

    public function update(Request $request, FuelLog $fuelLog)
    {
        $fuelLog->update($this->validated($request));

        return redirect()->route('fuel-logs.index')->with('success', 'Fuel log updated.');
    }

    public function destroy(FuelLog $fuelLog)
    {
        $fuelLog->delete();

        return redirect()->route('fuel-logs.index')->with('success', 'Fuel log deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'trip_id' => 'nullable|exists:trips,id',
            'fueled_at' => 'required|date',
            'liters' => 'required|numeric|min:0.01',
            'cost' => 'required|numeric|min:0',
            'odometer' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);
    }
}
