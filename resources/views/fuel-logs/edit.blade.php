@extends('layouts.app')@section('title','Edit Fuel Log')@section('page_title','Edit Fuel Log')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('fuel-logs.update',$fuelLog) }}">@csrf @method('PUT')
@include('fuel-logs._form')
<div class="mt-4"><button class="btn btn-primary">Update</button> <a href="{{ route('fuel-logs.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
