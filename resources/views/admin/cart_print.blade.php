@extends('admin.layout')

@section('title','Report page')

@section('content')

    <h1>
        @dump(session('cart'))
    </h1>

@endsection
