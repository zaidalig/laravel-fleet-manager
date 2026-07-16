<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRecord::with('vehicle');

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->input('vehicle_id'));
        }

        if ($request->filled('from')) {
            $query->whereDate('service_date', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('service_date', '<=', $request->input('to'));
        }

        $records = $query->latest('service_date')->paginate(10)->withQueryString();
        $vehicles = Vehicle::orderBy('plate_number')->get();

        return view('maintenance.index', compact('records', 'vehicles'));
    }

    public function create()
    {
        $vehicles = Vehicle::orderBy('plate_number')->get();

        return view('maintenance.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        MaintenanceRecord::create($data);

        return redirect()->route('maintenance.index')->with('success', 'Maintenance record created.');
    }

    public function edit(MaintenanceRecord $maintenance)
    {
        $vehicles = Vehicle::orderBy('plate_number')->get();

        return view('maintenance.edit', compact('maintenance', 'vehicles'));
    }

    public function update(Request $request, MaintenanceRecord $maintenance)
    {
        $maintenance->update($this->validated($request));

        return redirect()->route('maintenance.index')->with('success', 'Maintenance record updated.');
    }

    public function destroy(MaintenanceRecord $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('maintenance.index')->with('success', 'Maintenance record deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_date' => 'required|date',
            'title' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'next_service_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);
    }
}
