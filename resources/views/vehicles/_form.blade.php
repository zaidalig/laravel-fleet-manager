<div class="row g-3">
<div class="col-md-3"><label class="form-label">Plate Number</label><input name="plate_number" class="form-control" value="{{ old('plate_number', $vehicle->plate_number ?? '') }}" required></div>
<div class="col-md-3"><label class="form-label">Make</label><input name="make" class="form-control" value="{{ old('make', $vehicle->make ?? '') }}" required></div>
<div class="col-md-3"><label class="form-label">Model</label><input name="model" class="form-control" value="{{ old('model', $vehicle->model ?? '') }}" required></div>
<div class="col-md-3"><label class="form-label">Year</label><input type="number" name="year" class="form-control" value="{{ old('year', $vehicle->year ?? '') }}"></div>
<div class="col-md-3"><label class="form-label">Type</label><select name="type" class="form-select">@foreach(['car','van','truck','bike'] as $t)<option value="{{ $t }}" @selected(old('type', $vehicle->type ?? 'car')===$t)>{{ ucfirst($t) }}</option>@endforeach</select></div>
<div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['available','in_use','maintenance','retired'] as $s)<option value="{{ $s }}" @selected(old('status', $vehicle->status ?? 'available')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
<div class="col-md-3"><label class="form-label">Odometer (km)</label><input type="number" name="odometer" class="form-control" value="{{ old('odometer', $vehicle->odometer ?? 0) }}" required></div>
<div class="col-md-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $vehicle->notes ?? '') }}</textarea></div>
<div class="col-md-8"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp"><div class="form-text">JPG, PNG, or WEBP up to 4 MB.@if(isset($vehicle) && $vehicle->photo_path) Uploading a new photo replaces the current one.@endif</div></div>
@if(isset($vehicle) && $vehicle->photo_path)<div class="col-md-4 d-flex align-items-center"><img src="{{ asset('storage/'.$vehicle->photo_path) }}" alt="{{ $vehicle->plate_number }}" class="rounded me-2" style="width:48px;height:48px;object-fit:cover;"><span class="text-muted small">Current photo</span></div>@endif
</div>
