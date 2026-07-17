<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('employee_code', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        [$perPage, $sort, $direction] = $this->listQueryParams($request, ['name', 'license_number', 'status', 'created_at'], 'created_at');
        $drivers = $query->orderBy($sort, $direction)->paginate($perPage)->withQueryString();

        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        $users = User::where('role', 'driver')->where('status', 'active')->orderBy('name')->get();

        return view('drivers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $driver = Driver::create($this->validated($request));

        return redirect()->route('drivers.index')
            ->with('success', "Driver \"{$driver->name}\" created.");
    }

    public function show(Driver $driver)
    {
        $driver->load([
            'user',
            'trips' => fn ($q) => $q->with('vehicle')->latest('started_at')->limit(10),
        ]);

        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        $users = User::where('role', 'driver')->where('status', 'active')->orderBy('name')->get();

        return view('drivers.edit', compact('driver', 'users'));
    }

    public function update(Request $request, Driver $driver)
    {
        $driver->update($this->validated($request, $driver));

        return redirect()->route('drivers.show', $driver)
            ->with('success', "Driver \"{$driver->name}\" updated.");
    }

    public function destroy(Driver $driver)
    {
        $name = $driver->name;
        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', "Driver \"{$name}\" deleted.");
    }

    protected function validated(Request $request, ?Driver $driver = null): array
    {
        return $request->validate([
            'employee_code' => 'required|string|max:50|unique:drivers,employee_code,'.($driver?->id ?? 'NULL'),
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'license_number' => 'nullable|string|max:100',
            'license_expiry' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'user_id' => 'nullable|exists:users,id',
        ]);
    }
}
