@extends('layouts.app')@section('title','Fuel Report')@section('page_title','Fuel Report')
@section('content')
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2 align-items-end">
<div class="col-md-3"><label class="form-label mb-1">From</label><input type="date" name="from" class="form-control" value="{{ $from }}"></div>
<div class="col-md-3"><label class="form-label mb-1">To</label><input type="date" name="to" class="form-control" value="{{ $to }}"></div>
<div class="col-md-3"><button class="btn btn-dark w-100">Apply</button></div>
<div class="col-md-3"><a href="{{ route('reports.fuel', ['from' => $from, 'to' => $to, 'export' => 1]) }}" class="btn btn-outline-success w-100"><i class="fa-solid fa-file-csv me-1"></i>Export CSV</a></div>
</form></div></div>
<div class="row g-4 mb-4">
<div class="col-md-6"><div class="card stat-card card-primary p-3"><div class="d-flex justify-content-between"><div><div class="text-muted small">Total Liters</div><h3 class="fw-bold mb-0">{{ number_format($totalLiters, 2) }} L</h3></div><div class="card-icon bg-primary-subtle text-primary"><i class="fa-solid fa-gas-pump"></i></div></div></div></div>
<div class="col-md-6"><div class="card stat-card card-success p-3"><div class="d-flex justify-content-between"><div><div class="text-muted small">Total Cost</div><h3 class="fw-bold mb-0">${{ number_format($totalCost, 2) }}</h3></div><div class="card-icon bg-success-subtle text-success"><i class="fa-solid fa-dollar-sign"></i></div></div></div></div>
</div>
<div class="card card-table border-0"><div class="card-header bg-white fw-bold">Per-Vehicle Breakdown ({{ $from }} to {{ $to }})</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Vehicle</th><th>Make / Model</th><th class="text-end">Entries</th><th class="text-end">Liters</th><th class="text-end">Cost</th></tr></thead><tbody>
@forelse($byVehicle as $row)
<tr><td class="fw-semibold">{{ $row['plate'] }}</td><td>{{ $row['make_model'] }}</td><td class="text-end">{{ $row['entries'] }}</td><td class="text-end">{{ number_format($row['liters'], 2) }} L</td><td class="text-end fw-bold">${{ number_format($row['cost'], 2) }}</td></tr>
@empty<tr><td colspan="5" class="text-center py-4 text-muted">No fuel logs in range.</td></tr>@endforelse
</tbody></table></div></div>
@endsection
