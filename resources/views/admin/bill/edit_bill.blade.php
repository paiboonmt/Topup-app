@extends('admin.layout')
@section('title', 'แก้ไขบิล')
@section('content')

    <style>
        .colSet {
            padding-left: 10px;
            margin: 10px;
        }
    </style>

    <form action="{{ route('admin.update_bill' , $data[0]->code ) }}" method="post">
        @csrf

        <div class="row p-1">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h4>ฟอร์มแก้ไขบิล</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ชื่อสินค้า</th>
                                            <th>ราคา</th>
                                            <th>จำนวนสินค้า</th>
                                            <th>ราคารวม</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sum = 0;
                                        @endphp
                                        @foreach ($data as $i)
                                            <tr>
                                                <td>{{ $i->product_name }}</td>
                                                <td>{{ $i->price }}</td>
                                                <td>{{ $i->oqut }}</td>
                                                <td>
                                                    {{ number_format($i->price * $i->oqut, 2) }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.remove_item_bill', ['code' => $i->code, 'id' => $i->id]) }}"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $sum += $i->price * $i->oqut;
                                            @endphp
                                        @endforeach
                                    </tbody>

                                    <tr>
                                        <td colspan="3">ยอดรวมสินค้า</td>
                                        <td>{{ number_format($sum, 2) }}</td>
                                        <input type="hidden" value="{{ $sum }}" name="totel" >
                                        <td></td>
                                    </tr>

                                    @if ($data[0]->discount != 0)
                                        <tr>
                                            <td>ส่วนลด</td>
                                            <td colspan="2">{{ $data[0]->discount }} %</td>
                                            <td>{{ number_format($data[0]->net_discount, 2) }}</td>
                                            <td colspan="2">
                                                <a href="{{ route('admin.remove_discount' , $data[0]->code ) }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            @php
                                                $total = 0;
                                            @endphp
                                            <td>{{ number_format($total - $data[0]->net_discount, 2) }}</td>
                                        </tr>
                                    @endif

                                    @if ($data[0]->vat7 !== 0)
                                        <tr>
                                            <td>ภาษี</td>
                                            <td colspan="2">{{ $data[0]->vat7 }} %</td>
                                            @php
                                                $net = ($sum * 7) / 100;
                                            @endphp
                                            <td colspan="2">{{ number_format($net, 2) }}</td>
                                        </tr>
                                    @endif

                                    @if ($data[0]->vat3 !== 0)
                                        <tr>
                                            <td>ภาษี</td>
                                            <td colspan="2">{{ $data[0]->vat3 }} %</td>
                                            @php
                                                $net = ($sum * 3) / 100;
                                            @endphp
                                            <td>{{ number_format($net, 2) }}</td>
                                            <td>
                                                <a href="{{ route('admin.remove_vat', ['code' => $data[0]->code, 'id' => $data[0]->vat3]) }}"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($data[0]->vat3 === 0 || $data[0]->vat7 === 0)
                                        @php
                                            $net = 0;
                                        @endphp
                                    @endif

                                    <tr>
                                        <td colspan="3">ยอดรวมทั้งหมด</td>
                                        <td colspan="2">{{ number_format($data[0]->ototal, 2) }}</td>
                                        <input type="hidden" value="{{ $data[0]->ototal }}" name="sum">
                                    </tr>

                                    <tr>
                                        <td colspan="2">วิธีชำระ</td>
                                        <td colspan="3">{{ $i->payment }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">หมายเลขบัตร</td>
                                        <td colspan="3">{{ $data[0]->code }}</td>
                                        <input type="hidden" value="{{ $data[0]->code }}" name="code">
                                    </tr>

                                    <tr>
                                        <td colspan="2">หมายเลขบิล</td>
                                        <td colspan="3">{{ $data[0]->num_bill }}</td>
                                        <input type="hidden" value="{{ $data[0]->num_bill }}" name="num_bill">
                                    </tr>

                                    <tr>
                                        <td colspan="2">ชื่อลูกค้า</td>
                                        <td colspan="3">
                                            <input type="text" class="form-control" name="fname"
                                                value="{{ $data[0]->fname }}">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">วิธีชำระ</td>
                                        <td colspan="3">
                                            <select class="form-control" name="payment">
                                                @foreach ($payment as $i)
                                                    <option value="{{ $i->name .'|'. $i->value }}">{{ $i->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">วันที่เริ่มต้น</span>
                                            </div>
                                            <input type="date" name="sta_date" class="form-control" value="{{ $data[0]->sta_date }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">วันที่เริ่มต้น</span>
                                            </div>
                                            <input type="date" name="exp_date" class="form-control" value="{{ $data[0]->exp_date }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <textarea name="comment" class="form-control" cols="30" rows="10">{{ $data[0]->comment }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <input type="submit" class="btn btn-success col" value="บันทึกข้อมูล">
            </div>
        </div>

        </div>
    </form>

@endsection

