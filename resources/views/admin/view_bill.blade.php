@extends('admin.layout')

@section('title', 'Report page')

@section('content')

    <div class="row p-2">
        <div class="col-8 mx-auto">
            <div class="card p-1">
                <form action="" method="post">

                    <div class="text-center bg-dark" >
                        <h1>ฟอร์มแก้ไขบิล</h1>
                    </div>

                    <div class="row">
                        <div class="col p-2">
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
                                                {{ $i->price * $i->quantity }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">ยอดรวมสินค้า</td>
                                        <td>{{ number_format($data[0]->ototal,2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">หมายเลขบัตร</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->code }}">
                    </div>
                    
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">หมายเลขบิล</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->num_bill }}">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ชื่อลูกค้า</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->fname }}">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">วิธีการจ่าย</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->payment }}">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ส่วนลด</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->discount }}">
                    </div>


                    @if ( $data[0]->vat7 != 0 )
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">ภาษี 7%</span>
                            </div>
                            <input type="text" class="form-control" value="{{ $data[0]->net }} บาท">
                        </div>
                    @endif

                    @if ( $data[0]->vat3 != 0 )
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">ภาษี 3%</span>
                            </div>
                            <input type="text" class="form-control" value="{{ $data[0]->net }} บาท">
                        </div>
                    @endif

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ยอดรวม</span>
                        </div>
                        <input type="text" class="form-control" value="{{ number_format($data[0]->ototal,2) }}">
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

                </form>
            </div>
        </div>
    </div>

@endsection
