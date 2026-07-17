<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Services\MediaStorage;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('plate_number', 'like', "%{$search}%")
                    ->orWhere('make', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        [$perPage, $sort, $direction] = $this->listQueryParams($request, ['plate_number', 'make', 'model', 'status', 'created_at'], 'created_at');
        $vehicles = $query->orderBy($sort, $direction)->paginate($perPage)->withQueryString();

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = MediaStorage::store($request->file('photo'), 'vehicle-photos');
        }

        $vehicle = Vehicle::create($data);

        return redirect()->route('vehicles.index')
            ->with('success', "Vehicle \"{$vehicle->plate_number}\" created.");
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load([
            'trips' => fn ($q) => $q->with('driver')->latest('started_at')->limit(10),
            'fuelLogs' => fn ($q) => $q->latest('fueled_at')->limit(10),
            'maintenanceRecords' => fn ($q) => $q->latest('service_date')->limit(10),
        ]);

        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $this->validated($request, $vehicle);

        if ($request->hasFile('photo')) {
            if ($vehicle->photo_path) {
                MediaStorage::delete($vehicle->photo_path);
            }
            $data['photo_path'] = MediaStorage::store($request->file('photo'), 'vehicle-photos');
        }

        $vehicle->update($data);

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', "Vehicle \"{$vehicle->plate_number}\" updated.");
    }

    public function destroy(Vehicle $vehicle)
    {
        $plate = $vehicle->plate_number;

        if ($vehicle->photo_path) {
            MediaStorage::delete($vehicle->photo_path);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', "Vehicle \"{$plate}\" deleted.");
    }

    protected function validated(Request $request, ?Vehicle $vehicle = null): array
    {
        return $request->validate([
            'plate_number' => 'required|string|max:50|unique:vehicles,plate_number,'.($vehicle?->id ?? 'NULL'),
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'nullable|integer|min:1980|max:2100',
            'type' => 'required|in:car,van,truck,bike',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'odometer' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
    }
}
