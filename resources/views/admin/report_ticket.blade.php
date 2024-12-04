@extends('admin.layout')

@section('title','report')

@section('content')

<div class="row">
    <div class="col p-1">
        <div class="card p-1">
            <table class="table" id="example1">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Bill</th>
                        <th hidden>name</th>
                        <th>Product name</th>
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
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->num_bill }}</td>
                            <td hidden>{{ $item->fname }}</td>
                            <td>
                                @php
                                    $products = DB::table('order_details')
                                    ->select(DB::raw('GROUP_CONCAT(product_name) as product_names'), 'order_id' , DB::raw('MAX(quantity) as quantity') , DB::raw('MAX(product_id) as product_id') , DB::raw('MAX(total) as total'))
                                    ->where('order_id', $item->code)
                                    ->groupBy('order_id','product_id')
                                    ->get();
                                @endphp
                                @foreach ($products as $product)
                                        {{ $product->product_names }} | * | {{ $product->quantity }} | {{ $product->total }}<br>
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
                                <a href="{{ route('admin.reprint_ticket' , $item->code ) }}" class="btn btn-success btn-sm"><i class="fas fa-print"></i></a>
                                <a href="{{ route('admin.view_bill' , $item->code) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
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

