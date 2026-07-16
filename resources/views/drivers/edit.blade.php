@extends('layouts.app')@section('title','Edit Driver')@section('page_title','Edit Driver')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('drivers.update',$driver) }}">@csrf @method('PUT')
@include('drivers._form')
<div class="mt-4"><button class="btn btn-primary">Update</button> <a href="{{ route('drivers.show',$driver) }}" class="btn btn-light">Back</a></div></form></div>@endsection
