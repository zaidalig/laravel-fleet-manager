<?php

namespace App\Http\Controllers;

use App\Models\FuelLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FuelReportController extends Controller
{
    public function index(Request $request)
    {
        [$from, $to] = $this->dateRange($request);

        if ($request->boolean('export')) {
            return $this->export($from, $to);
        }

        $logs = $this->rangeQuery($from, $to)
            ->with('vehicle')
            ->orderBy('fueled_at')
            ->orderBy('id')
            ->get();

        $totalLiters = (float) $logs->sum('liters');
        $totalCost = (float) $logs->sum('cost');

        $byVehicle = $logs->groupBy('vehicle_id')->map(function ($group) {
            $vehicle = $group->first()->vehicle;

            return [
                'plate' => $vehicle?->plate_number ?? 'Unknown',
                'make_model' => $vehicle ? trim("{$vehicle->make} {$vehicle->model}") : '-',
                'entries' => $group->count(),
                'liters' => (float) $group->sum('liters'),
                'cost' => (float) $group->sum('cost'),
            ];
        })->sortBy('plate')->values();

        return view('reports.fuel', compact('from', 'to', 'totalLiters', 'totalCost', 'byVehicle', 'logs'));
    }

    protected function export(string $from, string $to): StreamedResponse
    {
        $logs = $this->rangeQuery($from, $to)
            ->with('vehicle')
            ->orderBy('fueled_at')
            ->orderBy('id')
            ->get();

        return response()->streamDownload(function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Vehicle plate', 'Liters', 'Cost', 'Odometer', 'Notes']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->fueled_at->format('Y-m-d'),
                    $log->vehicle?->plate_number ?? '',
                    $log->liters,
                    $log->cost,
                    $log->odometer ?? '',
                    $log->notes ?? '',
                ]);
            }

            fclose($handle);
        }, 'fuel-report.csv', ['Content-Type' => 'text/csv']);
    }

    protected function dateRange(Request $request): array
    {
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ]);

        $from = $request->input('from') ?: now()->startOfMonth()->toDateString();
        $to = $request->input('to') ?: now()->endOfMonth()->toDateString();

        return [$from, $to];
    }

    protected function rangeQuery(string $from, string $to)
    {
        return FuelLog::whereDate('fueled_at', '>=', $from)
            ->whereDate('fueled_at', '<=', $to);
    }
}
