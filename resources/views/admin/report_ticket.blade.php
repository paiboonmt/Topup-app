@extends('admin.layout')

@section('title','report')

@section('content')

<div class="row">
    <div class="col p-1">
        <div class="card p-1">
            <table class="table" id="example1">
                <thead>
                    <tr>
                        <th hidden>Code</th>
                        <th>หมายเลขบิล</th>
                        <th hidden>name</th>
                        <th>รายการสินค้า</th>
                        <th>ส่วนลด</th>
                        <th class="text-center">การเพื่มภาษี</th>
                        <th>ยอดรวม</th>
                        <th>การชำระ</th>
                        <th>ผู้ขาย</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td hidden>{{ $item->code }}</td>
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
                            <td>{{ $item->discount }} % / {{  number_format($item->net_discount,2) }}</td>
                            <td class="text-center">
                                @if ($item->vat7 != 0)
                                    {{ $item->vat7 }} % / {{ number_format($item->net,2) }}
                                @else
                                    {{ $item->vat3 }} % / {{ number_format($item->net,2) }}
                                @endif
                            </td>
                            <td>{{ number_format($item->total,2) }}</td>
                            <td>{{ $item->payment }}</td>
                            <td>{{ $item->user }}</td>
                            <td>
                                <a href="{{ route('admin.reprint_ticket' , $item->code ) }}" class="btn btn-success btn-sm"><i class="fas fa-print"></i></a>
                                <a href="{{ route('admin.edit_bill' , $item->code) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
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

