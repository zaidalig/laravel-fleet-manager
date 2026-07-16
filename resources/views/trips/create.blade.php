@extends('layouts.app')@section('title','New Trip')@section('page_title','New Trip')
@section('content')
<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('trips.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Vehicle</label><select name="vehicle_id" class="form-select" required><option value="">Select</option>@foreach($vehicles as $v)<option value="{{ $v->id }}" @selected(old('vehicle_id')==$v->id)>{{ $v->plate_number }} — {{ $v->make }} {{ $v->model }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Driver</label><select name="driver_id" class="form-select" required><option value="">Select</option>@foreach($drivers as $d)<option value="{{ $d->id }}" @selected(old('driver_id')==$d->id)>{{ $d->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Start Location</label><input name="start_location" class="form-control" value="{{ old('start_location') }}" required></div>
<div class="col-md-6"><label class="form-label">End Location</label><input name="end_location" class="form-control" value="{{ old('end_location') }}" required></div>
<div class="col-md-4"><label class="form-label">Started At</label><input type="datetime-local" name="started_at" class="form-control" value="{{ old('started_at', now()->format('Y-m-d\TH:i')) }}" required></div>
<div class="col-md-4"><label class="form-label">Ended At</label><input type="datetime-local" name="ended_at" class="form-control" value="{{ old('ended_at') }}"></div>
<div class="col-md-4"><label class="form-label">Distance (km)</label><input type="number" step="0.1" name="distance_km" class="form-control" value="{{ old('distance_km', 0) }}"></div>
<div class="col-md-8"><label class="form-label">Purpose</label><input name="purpose" class="form-control" value="{{ old('purpose') }}"></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['planned','in_progress','completed','cancelled'] as $s)<option value="{{ $s }}" @selected(old('status','planned')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
</div>
@if($errors->any())<div class="alert alert-danger mt-3"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<div class="mt-4"><button class="btn btn-primary">Create Trip</button> <a href="{{ route('trips.index') }}" class="btn btn-light">Cancel</a></div>
</form></div>
@endsection
