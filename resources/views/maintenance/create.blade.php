@extends('layouts.app')@section('title','Add Maintenance')@section('page_title','Add Maintenance')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('maintenance.store') }}">@csrf
@include('maintenance._form')
<div class="mt-4"><button class="btn btn-primary">Save</button> <a href="{{ route('maintenance.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
