<div class="row g-3">
<div class="col-md-4"><label class="form-label">Vehicle</label><select name="vehicle_id" class="form-select" required><option value="">Select</option>@foreach($vehicles as $v)<option value="{{ $v->id }}" @selected(old('vehicle_id', $fuelLog->vehicle_id ?? '')==$v->id)>{{ $v->plate_number }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Trip (optional)</label><select name="trip_id" class="form-select"><option value="">None</option>@foreach($trips as $t)<option value="{{ $t->id }}" @selected(old('trip_id', $fuelLog->trip_id ?? '')==$t->id)>{{ $t->trip_number }} — {{ $t->vehicle->plate_number }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Fueled At</label><input type="date" name="fueled_at" class="form-control" value="{{ old('fueled_at', isset($fuelLog) ? $fuelLog->fueled_at->format('Y-m-d') : date('Y-m-d')) }}" required></div>
<div class="col-md-3"><label class="form-label">Liters</label><input type="number" step="0.01" name="liters" class="form-control" value="{{ old('liters', $fuelLog->liters ?? '') }}" required></div>
<div class="col-md-3"><label class="form-label">Cost</label><input type="number" step="0.01" name="cost" class="form-control" value="{{ old('cost', $fuelLog->cost ?? '') }}" required></div>
<div class="col-md-3"><label class="form-label">Odometer</label><input type="number" name="odometer" class="form-control" value="{{ old('odometer', $fuelLog->odometer ?? '') }}"></div>
<div class="col-md-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $fuelLog->notes ?? '') }}</textarea></div>
</div>
