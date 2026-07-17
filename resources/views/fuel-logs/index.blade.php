@extends('layouts.app')@section('title','Fuel Logs')@section('page_title','Fuel Logs')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Fuel consumption and costs.</p><a href="{{ route('fuel-logs.create') }}" class="btn btn-primary rounded-pill">Add Fuel Log</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-4"><select name="vehicle_id" class="form-select form-select-sm form-select-compact"><option value="">All Vehicles</option>@foreach($vehicles as $v)<option value="{{ $v->id }}" @selected(request('vehicle_id')==$v->id)>{{ $v->plate_number }}</option>@endforeach</select></div>
<div class="col-md-2"><input type="date" name="from" class="form-control" value="{{ request('from') }}" placeholder="From"></div>
<div class="col-md-2"><input type="date" name="to" class="form-control" value="{{ request('to') }}" placeholder="To"></div>
<div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['vehicle_id','from','to']))<a href="{{ route('fuel-logs.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Date</th><th>Vehicle</th><th>Trip</th><th>Liters</th><th>Cost</th><th>Odometer</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($fuelLogs as $f)
<tr><td>{{ $f->fueled_at->format('M d, Y') }}</td><td>{{ $f->vehicle->plate_number }}</td><td>{{ $f->trip?->trip_number ?? '-' }}</td><td>{{ $f->liters }}</td><td>${{ number_format($f->cost,2) }}</td><td>{{ $f->odometer ? number_format($f->odometer) : '-' }}</td>
<td class="text-end"><span class="table-actions"><a href="{{ route('fuel-logs.edit',$f) }}" class="btn btn-sm btn-outline-primary" title="Edit" aria-label="Edit"><i class="fa-solid fa-pen"></i></a> <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('fuel-logs.destroy',$f) }}" data-name="fuel log {{ $f->fueled_at->format('Y-m-d') }}"><i class="fa-solid fa-trash"></i></button></span></td></tr>
@empty<tr><td colspan="7" class="text-center py-4 text-muted">No fuel logs found.</td></tr>@endforelse
</tbody></table></div><x-table-pagination :paginator="$fuelLogs" :sorts="['fueled_at'=>'Date','liters'=>'Liters','cost'=>'Cost','created_at'=>'Created']" /></div>
@endsection
