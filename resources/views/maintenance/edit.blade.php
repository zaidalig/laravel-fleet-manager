@extends('layouts.app')@section('title','Edit Maintenance')@section('page_title','Edit Maintenance')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('maintenance.update',$maintenance) }}">@csrf @method('PUT')
@include('maintenance._form')
<div class="mt-4"><button class="btn btn-primary">Update</button> <a href="{{ route('maintenance.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
