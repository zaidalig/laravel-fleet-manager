@extends('layouts.app')@section('title','Trips')@section('page_title','Trips')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Trip planning and tracking.</p><a href="{{ route('trips.create') }}" class="btn btn-primary rounded-pill">New Trip</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-2"><select name="status" class="form-select"><option value="">All Status</option>@foreach(['planned','in_progress','completed','cancelled'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
<div class="col-md-3"><select name="driver_id" class="form-select"><option value="">All Drivers</option>@foreach($drivers as $d)<option value="{{ $d->id }}" @selected(request('driver_id')==$d->id)>{{ $d->name }}</option>@endforeach</select></div>
<div class="col-md-3"><select name="vehicle_id" class="form-select"><option value="">All Vehicles</option>@foreach($vehicles as $v)<option value="{{ $v->id }}" @selected(request('vehicle_id')==$v->id)>{{ $v->plate_number }}</option>@endforeach</select></div>
<div class="col-md-2"><input type="date" name="date" class="form-control" value="{{ request('date') }}"></div>
<div class="col-md-2 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['status','driver_id','vehicle_id','date']))<a href="{{ route('trips.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Trip #</th><th>Vehicle</th><th>Driver</th><th>Route</th><th>Started</th><th>Status</th></tr></thead><tbody>
@forelse($trips as $t)
<tr><td><a href="{{ route('trips.show',$t) }}" class="fw-bold text-decoration-none">{{ $t->trip_number }}</a></td><td>{{ $t->vehicle->plate_number }}</td><td>{{ $t->driver->name }}</td><td>{{ $t->start_location }} → {{ $t->end_location }}</td><td>{{ $t->started_at->format('M d, Y H:i') }}</td><td><span class="badge {{ $t->status==='completed'?'bg-success-subtle text-success':($t->status==='in_progress'?'bg-info-subtle text-info':($t->status==='cancelled'?'bg-danger-subtle text-danger':'bg-warning-subtle text-warning')) }}">{{ ucfirst(str_replace('_',' ',$t->status)) }}</span></td></tr>
@empty<tr><td colspan="6" class="text-center py-4 text-muted">No trips found.</td></tr>@endforelse
</tbody></table></div>@if($trips->hasPages())<div class="card-footer bg-white">{{ $trips->links() }}</div>@endif</div>
@endsection
