@extends('layouts.app')@section('title','Add Driver')@section('page_title','Add Driver')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('drivers.store') }}">@csrf
@include('drivers._form')
<div class="mt-4"><button class="btn btn-primary">Save Driver</button> <a href="{{ route('drivers.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
