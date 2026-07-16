@extends('layouts.app')@section('title','Edit Vehicle')@section('page_title','Edit Vehicle')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('vehicles.update',$vehicle) }}" enctype="multipart/form-data">@csrf @method('PUT')
@include('vehicles._form')
<div class="mt-4"><button class="btn btn-primary">Update</button> <a href="{{ route('vehicles.show',$vehicle) }}" class="btn btn-light">Back</a></div></form></div>@endsection
