<div class="row g-3">
<div class="col-md-4"><label class="form-label">Vehicle</label><select name="vehicle_id" class="form-select" required><option value="">Select</option>@foreach($vehicles as $v)<option value="{{ $v->id }}" @selected(old('vehicle_id', $maintenance->vehicle_id ?? '')==$v->id)>{{ $v->plate_number }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Service Date</label><input type="date" name="service_date" class="form-control" value="{{ old('service_date', isset($maintenance) ? $maintenance->service_date->format('Y-m-d') : date('Y-m-d')) }}" required></div>
<div class="col-md-4"><label class="form-label">Next Service Date</label><input type="date" name="next_service_date" class="form-control" value="{{ old('next_service_date', isset($maintenance) && $maintenance->next_service_date ? $maintenance->next_service_date->format('Y-m-d') : '') }}"></div>
<div class="col-md-8"><label class="form-label">Title</label><input name="title" class="form-control" value="{{ old('title', $maintenance->title ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label">Cost</label><input type="number" step="0.01" name="cost" class="form-control" value="{{ old('cost', $maintenance->cost ?? 0) }}" required></div>
<div class="col-md-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $maintenance->notes ?? '') }}</textarea></div>
</div>
