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
                        <th hidden>code</th>
                        <th>bill</th>
                        <th hidden>name</th>
                        <th>product</th>
                        <th>discount</th>
                        <th>vat7</th>
                        <th>vat3</th>
                        <th>net</th>
                        <th>total</th>
                        <th>payment</th>
                        <th>user</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td hidden>{{ $item->id }}</td>
                            <td hidden>{{ $item->code }}</td>
                            <td>{{ $item->num_bill }}</td>
                            <td hidden>{{ $item->fname }}</td>
                            <td>
                                @foreach ($produsts as $i)
                                    {{ $i->product_name }}
                                @endforeach
                            </td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $item->vat7 }}</td>
                            <td>{{ $item->vat3 }}</td>
                            <td>{{ number_format($item->net,2) }}</td>
                            <td>{{ number_format($item->total,2) }}</td>
                            <td>{{ $item->payment }}</td>
                            <td>{{ $item->user }}</td>
                            <td>
                                <a href="{{ route('admin.reportDelete' , $item->code) }}" class="btn btn-sm btn-danger" onclick="return confirm('คุณแน่ใจแล้วใช่ไหมที่จะลบข้อมูล') ">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

