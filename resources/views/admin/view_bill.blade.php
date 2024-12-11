@extends('admin.layout')

@section('title', 'Report page')

@section('content')

<style>
    .colSet{
        padding-left: 10px;
        margin: 10px;
    }
</style>

    <div class="row p-2">
        <div class="col-5 mx-auto">
            <div class="card p-1">

                    
                <div class="card p-2 bg-dark">
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('admin.report_ticket') }}" class="btn btn-success" style="width: 150px">ย้อนกลับ</a>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.edit_bill',$data[0]->code ) }}" class="btn btn-warning" style="width: 150px; float: right; color: white">แก้ไขบิลนี้</a>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ชื่อสินค้า</th>
                                <th>ราคา</th>
                                <th>จำนวนสินค้า</th>
                                <th>ราคารวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i)
                                <tr>
                                    <td>{{ $i->product_name }}</td>
                                    <td>{{ $i->price }}</td>
                                    <td>{{ $i->quantity }}</td>
                                    <td>
                                        {{ number_format($i->price * $i->quantity,2) }}
                                    </td>
                                </tr>
                                <td hidden>{{ $total =  $i->price * $i->quantity }}</td>
                            @endforeach
                        </tbody>

                        @if ( $data[0]->discount != 0 )
                            <tr>
                                <td>ส่วนลด</td>
                                <td colspan="2">{{ $data[0]->discount }} %</td>
                                <td>{{ number_format($data[0]->net_discount,2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>{{ number_format($total - $data[0]->net_discount,2) }}</td>
                            </tr>      
                        @endif

                        @if ( $data[0]->vat7 != 0 )
                            <tr>
                                <td>ภาษี</td>
                                <td colspan="2">{{ $data[0]->vat7 }} %</td>
                                <td>{{ number_format($data[0]->net,2) }}</td>
                            </tr>
                        @endif

                        @if ( $data[0]->vat3 != 0 )
                            <tr>
                                <td>ภาษี 3%</td>
                                <td colspan="3">{{ $data[0]->net }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td colspan="3">ยอดรวม</td>
                            <td>{{ number_format($data[0]->ototal,2) }}</td>
                        </tr>

                        <tr>
                            <td>หมายเลขบัตร</td>
                            <td colspan="3">{{ $data[0]->code }}</td>
                        </tr>

                        <tr>
                            <td>หมายเลขบิล</td>
                            <td colspan="3">{{ $data[0]->num_bill }}</td>
                        </tr>

                        <tr>
                            <td>ชื่อลูกค้า</td>
                            <td colspan="3">{{ $data[0]->fname }}</td>
                        </tr>

                        <tr>
                            <td>วิธีชำระ</td>
                            <td colspan="3">{{ $data[0]->payment }}</td>
                        </tr>

                    </table>
                </div>
                   
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">วันที่เริ่มต้น</span>
                            </div>
                            <input type="date" class="form-control" value="{{ $data[0]->sta_date }}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">วันที่เริ่มต้น</span>
                            </div>
                            <input type="date" class="form-control" value="{{ $data[0]->exp_date }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <textarea  class="form-control" cols="30" rows="3">{{ $data[0]->comment }}</textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
