@extends('layouts.app')@section('title','Drivers')@section('page_title','Drivers')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Driver directory and licenses.</p><a href="{{ route('drivers.create') }}" class="btn btn-primary rounded-pill">Add Driver</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-5"><input name="search" class="form-control" placeholder="Search name, code, phone" value="{{ request('search') }}"></div>
<div class="col-md-3"><select name="status" class="form-select form-select-sm form-select-compact"><option value="">All Status</option>@foreach(['active','inactive'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['search','status']))<a href="{{ route('drivers.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Code</th><th>Name</th><th>Phone</th><th>License</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($drivers as $d)
<tr><td>{{ $d->employee_code }}</td><td><a href="{{ route('drivers.show',$d) }}" class="fw-bold text-decoration-none">{{ $d->name }}</a></td><td>{{ $d->phone ?? '-' }}</td><td>{{ $d->license_number ?? '-' }}@if($d->license_expiry)<br><small class="text-muted">Exp {{ $d->license_expiry->format('M Y') }}</small>@endif</td><td><span class="badge {{ $d->status==='active'?'bg-success-subtle text-success':'bg-danger-subtle text-danger' }}">{{ ucfirst($d->status) }}</span></td>
<td class="text-end"><span class="table-actions"><a href="{{ route('drivers.show',$d) }}" class="btn btn-sm btn-outline-secondary" title="View" aria-label="View"><i class="fa-solid fa-eye"></i></a> <a href="{{ route('drivers.edit',$d) }}" class="btn btn-sm btn-outline-primary" title="Edit" aria-label="Edit"><i class="fa-solid fa-pen"></i></a> <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('drivers.destroy',$d) }}" data-name="{{ $d->name }}"><i class="fa-solid fa-trash"></i></button></span></td></tr>
@empty<tr><td colspan="6" class="text-center py-4 text-muted">No drivers found.</td></tr>@endforelse
</tbody></table></div><x-table-pagination :paginator="$drivers" :sorts="['name'=>'Name','license_number'=>'License','status'=>'Status','created_at'=>'Created']" /></div>
@endsection
