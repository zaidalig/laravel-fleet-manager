@extends('layouts.app')@section('title','Maintenance')@section('page_title','Maintenance')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Service history and upcoming due dates.</p><a href="{{ route('maintenance.create') }}" class="btn btn-primary rounded-pill">Add Record</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-4"><select name="vehicle_id" class="form-select form-select-sm form-select-compact"><option value="">All Vehicles</option>@foreach($vehicles as $v)<option value="{{ $v->id }}" @selected(request('vehicle_id')==$v->id)>{{ $v->plate_number }}</option>@endforeach</select></div>
<div class="col-md-2"><input type="date" name="from" class="form-control" value="{{ request('from') }}"></div>
<div class="col-md-2"><input type="date" name="to" class="form-control" value="{{ request('to') }}"></div>
<div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['vehicle_id','from','to']))<a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Service Date</th><th>Vehicle</th><th>Title</th><th>Cost</th><th>Next Service</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($records as $r)
<tr class="{{ $r->isOverdue() ? 'table-danger' : '' }}"><td>{{ $r->service_date->format('M d, Y') }}</td><td>{{ $r->vehicle->plate_number }}</td><td>{{ $r->title }}@if($r->isOverdue()) <span class="badge bg-danger">Overdue</span>@endif</td><td>${{ number_format($r->cost,2) }}</td><td>{{ $r->next_service_date?->format('M d, Y') ?? '-' }}</td>
<td class="text-end"><span class="table-actions"><a href="{{ route('maintenance.edit',$r) }}" class="btn btn-sm btn-outline-primary" title="Edit" aria-label="Edit"><i class="fa-solid fa-pen"></i></a> <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('maintenance.destroy',$r) }}" data-name="{{ $r->title }}"><i class="fa-solid fa-trash"></i></button></span></td></tr>
@empty<tr><td colspan="6" class="text-center py-4 text-muted">No maintenance records.</td></tr>@endforelse
</tbody></table></div><x-table-pagination :paginator="$records" :sorts="['service_date'=>'Service date','cost'=>'Cost','created_at'=>'Created']" /></div>
@endsection
