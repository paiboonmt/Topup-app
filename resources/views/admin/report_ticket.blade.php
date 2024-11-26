@extends('admin.layout')

@section('title','report')

@section('content')

<div class="row">
    <div class="col p-1">
        <div class="card p-1">
            <table class="table" id="example1">
                <thead>
                    <tr>
                        <th hidden>id</th>
                        <th>code</th>
                        <th hidden>bill</th>
                        <th>name</th>
                        <th>discount</th>
                        <th>vat7</th>
                        <th>vat3</th>
                        <th>net</th>
                        <th>total</th>
                        <th>payment</th>
                        <th>user</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td hidden>{{ $item->id }}</td>
                            <td>{{ $item->code }}</td>
                            <td hidden>{{ $item->num_bill }}</td>
                            <td>{{ $item->fname }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $item->vat7 }}</td>
                            <td>{{ $item->vat3 }}</td>
                            <td>{{ number_format($item->net,2) }}</td>
                            <td>{{ number_format($item->total,2) }}</td>
                            <td>{{ $item->payment }}</td>
                            <td>{{ $item->user }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

