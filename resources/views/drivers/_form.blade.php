<div class="row g-3">
<div class="col-md-3"><label class="form-label">Employee Code</label><input name="employee_code" class="form-control" value="{{ old('employee_code', $driver->employee_code ?? '') }}" required></div>
<div class="col-md-5"><label class="form-label">Full Name</label><input name="name" class="form-control" value="{{ old('name', $driver->name ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone', $driver->phone ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">License Number</label><input name="license_number" class="form-control" value="{{ old('license_number', $driver->license_number ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">License Expiry</label><input type="date" name="license_expiry" class="form-control" value="{{ old('license_expiry', isset($driver) && $driver->license_expiry ? $driver->license_expiry->format('Y-m-d') : '') }}"></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['active','inactive'] as $s)<option value="{{ $s }}" @selected(old('status', $driver->status ?? 'active')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Linked User</label><select name="user_id" class="form-select"><option value="">None</option>@foreach($users as $u)<option value="{{ $u->id }}" @selected(old('user_id', $driver->user_id ?? '')==$u->id)>{{ $u->name }} ({{ $u->email }})</option>@endforeach</select></div>
</div>
