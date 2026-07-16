@extends('layouts.app')@section('title',$driver->name)@section('page_title',$driver->name)
@section('content')
<div class="row g-4">
<div class="col-lg-4"><div class="card p-4 border-0 shadow-sm"><h4 class="fw-bold mb-1">{{ $driver->name }}</h4><p class="text-muted mb-2">{{ $driver->employee_code }}</p>
<p class="mb-1"><i class="fa-solid fa-phone me-2 text-muted"></i>{{ $driver->phone ?? '-' }}</p>
<p class="mb-1"><i class="fa-solid fa-id-card me-2 text-muted"></i>{{ $driver->license_number ?? '-' }}</p>
<p class="mb-1"><i class="fa-solid fa-calendar me-2 text-muted"></i>License exp {{ $driver->license_expiry?->format('M d, Y') ?? '-' }}</p>
<p class="mb-3"><i class="fa-solid fa-user me-2 text-muted"></i>{{ $driver->user?->email ?? 'No linked user' }}</p>
<a href="{{ route('drivers.edit',$driver) }}" class="btn btn-sm btn-outline-primary">Edit Driver</a></div></div>
<div class="col-lg-8"><div class="card card-table border-0"><div class="card-header bg-white fw-bold">Recent Trips</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Trip</th><th>Vehicle</th><th>Route</th><th>Status</th></tr></thead><tbody>@forelse($driver->trips as $t)<tr><td><a href="{{ route('trips.show',$t) }}">{{ $t->trip_number }}</a></td><td>{{ $t->vehicle->plate_number }}</td><td>{{ $t->start_location }} → {{ $t->end_location }}</td><td>{{ ucfirst(str_replace('_',' ',$t->status)) }}</td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No trips.</td></tr>@endforelse</tbody></table></div></div></div>
</div>
@endsection
