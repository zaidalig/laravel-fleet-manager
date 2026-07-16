@extends('layouts.app')@section('title','Add Vehicle')@section('page_title','Add Vehicle')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data">@csrf
@include('vehicles._form')
<div class="mt-4"><button class="btn btn-primary">Save Vehicle</button> <a href="{{ route('vehicles.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
