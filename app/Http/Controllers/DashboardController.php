<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\FuelLog;
use App\Models\MaintenanceRecord;
use App\Models\Trip;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'vehicles' => Vehicle::count(),
            'available' => Vehicle::where('status', 'available')->count(),
            'active_trips' => Trip::where('status', 'in_progress')->count(),
            'fuel_cost_month' => FuelLog::whereMonth('fueled_at', now()->month)
                ->whereYear('fueled_at', now()->year)
                ->sum('cost'),
            'maintenance_due' => MaintenanceRecord::whereNotNull('next_service_date')
                ->whereDate('next_service_date', '<=', now()->endOfMonth())
                ->whereDate('next_service_date', '>=', now()->startOfMonth())
                ->count(),
        ];

        $recentTrips = Trip::with(['vehicle', 'driver'])->latest('started_at')->limit(5)->get();
        $upcomingMaintenance = MaintenanceRecord::with('vehicle')
            ->whereNotNull('next_service_date')
            ->whereDate('next_service_date', '<=', now()->addDays(30))
            ->orderBy('next_service_date')
            ->limit(5)
            ->get();
        $recentLogs = ActivityLog::with('user')->latest()->limit(8)->get();

        return view('dashboard', compact('stats', 'recentTrips', 'upcomingMaintenance', 'recentLogs'));
    }
}
