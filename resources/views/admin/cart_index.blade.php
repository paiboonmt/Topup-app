@extends('admin.layout')
@section('title', 'Cart page')

@section('content')

    <div class="row p-1">

        <div class="col-6">

           @include('admin.cart.cart')
           
        </div>

        <div class="col-6">

         @include('admin.cart.table_card')  

        </div>

    </div>

@endsection
