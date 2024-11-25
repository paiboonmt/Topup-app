@extends('admin.layout')

@section('title','Report page')

@section('content')

    <h1>
        @dump(session()->all())
    </h1>

    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    รายการ
                </div>
            </div>
        </div>
    </div>



@endsection
