@extends('layouts.app')@section('title',$trip->trip_number)@section('page_title',$trip->trip_number)
@section('content')
<div class="row g-4">
<div class="col-lg-7">
<div class="card p-4 border-0 shadow-sm mb-4">
<div class="d-flex justify-content-between align-items-start mb-3">
<div><h4 class="fw-bold mb-1">{{ $trip->trip_number }}</h4><p class="text-muted mb-0">{{ $trip->start_location }} → {{ $trip->end_location }}</p></div>
<span class="badge {{ $trip->status==='completed'?'bg-success-subtle text-success':($trip->status==='in_progress'?'bg-info-subtle text-info':($trip->status==='cancelled'?'bg-danger-subtle text-danger':'bg-warning-subtle text-warning')) }}">{{ ucfirst(str_replace('_',' ',$trip->status)) }}</span>
</div>
<p class="mb-1"><i class="fa-solid fa-car me-2 text-muted"></i>{{ $trip->vehicle->plate_number }} ({{ $trip->vehicle->make }} {{ $trip->vehicle->model }})</p>
<p class="mb-1"><i class="fa-solid fa-id-card me-2 text-muted"></i>{{ $trip->driver->name }}</p>
<p class="mb-1"><i class="fa-solid fa-clock me-2 text-muted"></i>{{ $trip->started_at->format('M d, Y H:i') }}@if($trip->ended_at) — {{ $trip->ended_at->format('M d, Y H:i') }}@endif</p>
<p class="mb-1"><i class="fa-solid fa-road me-2 text-muted"></i>{{ number_format($trip->distance_km,1) }} km</p>
<p class="mb-1"><i class="fa-solid fa-briefcase me-2 text-muted"></i>{{ $trip->purpose ?: 'No purpose' }}</p>
<p class="mb-0"><i class="fa-solid fa-user me-2 text-muted"></i>Logged by {{ $trip->user?->name ?? 'System' }}</p>
</div>
@if($trip->fuelLogs->count())
<div class="card card-table border-0"><div class="card-header bg-white fw-bold">Fuel on this trip</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Date</th><th>Liters</th><th>Cost</th></tr></thead><tbody>@foreach($trip->fuelLogs as $f)<tr><td>{{ $f->fueled_at->format('M d, Y') }}</td><td>{{ $f->liters }}</td><td>${{ number_format($f->cost,2) }}</td></tr>@endforeach</tbody></table></div></div>
@endif
</div>
<div class="col-lg-5">
<div class="card p-4 border-0 shadow-sm">
<h6 class="fw-bold mb-3">Update Status</h6>
<form method="POST" action="{{ route('trips.status',$trip) }}">@csrf @method('PATCH')
<div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['planned','in_progress','completed','cancelled'] as $s)<option value="{{ $s }}" @selected($trip->status===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label">Ended At</label><input type="datetime-local" name="ended_at" class="form-control" value="{{ $trip->ended_at?->format('Y-m-d\TH:i') }}"></div>
<div class="mb-3"><label class="form-label">Distance (km)</label><input type="number" step="0.1" name="distance_km" class="form-control" value="{{ $trip->distance_km }}"></div>
<button class="btn btn-dark">Update Status</button>
</form>
</div>
</div>
</div>
@endsection
