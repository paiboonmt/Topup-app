@extends('admin.layout')

@section('title','Report page')

@section('content')

<div class="row p-1">
    <div class="col-12">
        <div class="card p-2">
            <table class="table table-sm" id="example1">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Nationality</th>
                        <th>Type Training</th>
                        <th>Type Fighter</th>
                        <th>Affliate</th>
                        <th>Start</th>
                        <th>Expiry</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>
                                <a href="">
                                    <img src="http://172.16.0.3/fighterimg/img/{{ $item->image }}" style="border-radius: 50px; width: 50px; height: 50px ">
                                </a>
                            </td>
                            <td>{{ $item->fname }}</td>
                            <td>{{ $item->nationalty }}</td>
                            <td>{{ $item->type_training }}</td>
                            <td>{{ $item->type_fighter }}</td>
                            <td>{{ $item->affiliate }}</td>
                            <td>{{ $item->sta_date }}</td>
                            <td>{{ $item->exp_date }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
