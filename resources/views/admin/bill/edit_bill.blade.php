@extends('admin.layout')

@section('title', 'Report page')

@section('content')

    <style>
        .colSet {
            padding-left: 10px;
            margin: 10px;
        }
    </style>

    <form action="" method="post">
        @csrf

        <div class="row p-2">
            <div class="col-6">
                <div class="card p-1">
                    <div class="card p-2 bg-danger text-center">
                        <h5>ฟอร์มแก้ไขบิล</h5>
                    </div>
                    <div class="row">
                        <div class="col">
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
                                            <td>{{ $i->quantity }}</td>
                                            <td>
                                                {{ number_format($i->price * $i->quantity, 2) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.remove_item_bill', ['code' => $i->code, 'id' => $i->id]) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $sum += $i->price * $i->quantity;
                                        @endphp
                                    @endforeach

                                </tbody>

                                @if ( $data[0]->vat7 != 0 || $data[0]->vat3 != 0 )
                                 
                                    <tr>
                                        <td colspan="3">ยอดรวม</td>
                                        <td>{{ number_format($sum, 2) }}</td>
                                        <td></td>
                                    </tr>

                                    @if ($data[0]->discount != 0)
                                        <tr>
                                            <td>ส่วนลด</td>
                                            <td colspan="2">{{ $data[0]->discount }} %</td>
                                            <td>{{ number_format($data[0]->net_discount, 2) }}</td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td>{{ number_format($total - $data[0]->net_discount, 2) }}</td>
                                        </tr>
                                    @endif

                                    @if ($data[0]->vat7 != 0)
                                        <tr>
                                            <td>ภาษี</td>
                                            <td colspan="2">{{ $data[0]->vat7 }} %</td>
                                            @php
                                                $net = ($sum * 7) / 100;
                                            @endphp
                                            <td>{{ number_format($net, 2) }}</td>
                                            <td>
                                                <a href="{{ route('admin.remove_vat', ['code' => $data[0]->code, 'id' => $data[0]->vat7]) }}"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($data[0]->vat3 != 0)
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

                                    @if ($data[0]->vat3 == 0 || $data[0]->vat7 == 0)
                                        @php
                                            $net = 0;
                                        @endphp
                                    @endif

                                    <tr>
                                        <td colspan="3">ยอดรวมทั้งหมด</td>
                                        <td colspan="2">{{ number_format($sum + $net, 2) }}</td>
                                        <input type="hidden" value="{{ $sum + $net }}" name="sum">
                                    </tr>

                                @endif

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
                                        <input type="text" class="form-control" name="fname" value="{{ $data[0]->fname }}">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">วิธีชำระ</td>
                                    <td colspan="3">
                                        <select class="form-control" name="payment">
                                            <option value="">เงินสด</option>
                                            <option value="">บัตรเครดิต</option>
                                            <option value="">มันนี่การ์ด</option>
                                        </select>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

{{-- date start , date expiry , comment , submit --}}
            <div class="col-6">
                <div class="card p-1">
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">วันที่เริ่มต้น</span>
                                </div>
                                <input type="date" name="sta_date" class="form-control"
                                    value="{{ $data[0]->sta_date }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">วันที่เริ่มต้น</span>
                                </div>
                                <input type="date" name="exp_date" class="form-control"
                                    value="{{ $data[0]->exp_date }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <textarea name="comment" class="form-control" cols="30" rows="3">{{ $data[0]->comment }}</textarea>
                        </div>
                    </div>
                    @if ( $data[0]->vat7 == 0 || $data[0]->vat3 == 0 )

                        <div class="row mt-3">
                            <div class="col p-2">
                                <input type="submit" disabled  class="btn btn-success col" value="บันทึกข้อมูล">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col p-2">
                                <p class="text text-danger text-center">เพื่มวิธีการชำระ</p>
                            </div>
                        </div>

                    @endif

                </div>
            </div>
        </div>

    </form>

@endsection

<script>

</script>