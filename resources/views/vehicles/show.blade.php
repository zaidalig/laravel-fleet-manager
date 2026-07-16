@extends('layouts.app')@section('title',$vehicle->plate_number)@section('page_title',$vehicle->plate_number)
@section('content')
<div class="row g-4">
<div class="col-lg-4"><div class="card p-4 border-0 shadow-sm">
<div class="mb-3">@if($vehicle->photo_path)<img src="{{ asset('storage/'.$vehicle->photo_path) }}" alt="{{ $vehicle->plate_number }}" class="rounded" style="width:96px;height:96px;object-fit:cover;">@else<span class="rounded bg-light border d-inline-flex align-items-center justify-content-center" style="width:96px;height:96px;"><i class="fa-solid fa-car text-muted fs-2"></i></span>@endif</div>
<h4 class="fw-bold mb-1">{{ $vehicle->make }} {{ $vehicle->model }}</h4><p class="text-muted mb-2">{{ $vehicle->plate_number }} · {{ ucfirst($vehicle->type) }}@if($vehicle->year) · {{ $vehicle->year }}@endif</p>
<p class="mb-1"><i class="fa-solid fa-gauge-high me-2 text-muted"></i>{{ number_format($vehicle->odometer) }} km</p>
<p class="mb-3"><span class="badge {{ $vehicle->status==='available'?'bg-success-subtle text-success':'bg-info-subtle text-info' }}">{{ ucfirst(str_replace('_',' ',$vehicle->status)) }}</span></p>
@if($vehicle->notes)<p class="text-muted small">{{ $vehicle->notes }}</p>@endif
<a href="{{ route('vehicles.edit',$vehicle) }}" class="btn btn-sm btn-outline-primary">Edit Vehicle</a></div></div>
<div class="col-lg-8">
<div class="card card-table border-0 mb-4"><div class="card-header bg-white fw-bold">Recent Trips</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Trip</th><th>Driver</th><th>From → To</th><th>Status</th></tr></thead><tbody>@forelse($vehicle->trips as $t)<tr><td><a href="{{ route('trips.show',$t) }}">{{ $t->trip_number }}</a></td><td>{{ $t->driver->name }}</td><td>{{ $t->start_location }} → {{ $t->end_location }}</td><td>{{ ucfirst(str_replace('_',' ',$t->status)) }}</td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No trips.</td></tr>@endforelse</tbody></table></div></div>
<div class="card card-table border-0 mb-4"><div class="card-header bg-white fw-bold">Fuel Logs</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Date</th><th>Liters</th><th>Cost</th><th>Odometer</th></tr></thead><tbody>@forelse($vehicle->fuelLogs as $f)<tr><td>{{ $f->fueled_at->format('M d, Y') }}</td><td>{{ $f->liters }}</td><td>${{ number_format($f->cost,2) }}</td><td>{{ $f->odometer ? number_format($f->odometer) : '-' }}</td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No fuel logs.</td></tr>@endforelse</tbody></table></div></div>
<div class="card card-table border-0"><div class="card-header bg-white fw-bold">Maintenance</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Date</th><th>Title</th><th>Cost</th><th>Next</th></tr></thead><tbody>@forelse($vehicle->maintenanceRecords as $m)<tr class="{{ $m->isOverdue()?'table-danger':'' }}"><td>{{ $m->service_date->format('M d, Y') }}</td><td>{{ $m->title }}</td><td>${{ number_format($m->cost,2) }}</td><td>{{ $m->next_service_date?->format('M d, Y') ?? '-' }}</td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No maintenance records.</td></tr>@endforelse</tbody></table></div></div>
</div>
</div>
@endsection
