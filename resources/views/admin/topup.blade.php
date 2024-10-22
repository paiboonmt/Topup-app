@extends('admin.layout')

@section('title','Topup Money Application')

@section('content')

<div class="row">

    <div class="col-4 p-2">
        <div class="card p-2">
            <div class="card-header bg-dark"><h3>Topup Money</h3></div>
                <div class="card-body">
                    <form action="{{ route('admin.topup_check') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">Card :</span>
                            </div>
                            <input type="number" class="form-control" autofocus name="card" >
                        </div>
                    </form>

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                        </div>
                    @endif

                </div>
        </div>

        @if (session('data'))
            {{-- {{ dd(session('data')) }} --}}
            {{-- "id" => 4
            "card" => "0001385217"
            "status" => 1
            "code" => 1
            "created_at" => "2024-10-18 14:24:25"
            "updated_at" => "2024-10-18 14:24:25" --}}
        @endif



        @if (session('check'))
            <div class="alert alert-info" role="alert">
                {{ session('check') }}
            </div>

            <div class="card p-2">
                <form action="{{ route('admin.topup_store') }}" method="post">
                    @csrf
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                        <span class="input-group-text">หมายเลขบัตร :</span>
                        </div>
                        <input type="number" class="form-control" readonly name="card" value="{{ session('data')->card }}" >
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">จำนวนเงิน :</span>
                        </div>
                        <input type="number" class="form-control" name="price" value="1000" min="1">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ส่วนลด :</span>
                        </div>
                        <input type="number" class="form-control" name="discount" value="0">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">วิธีชำระเงิน :</span>
                        </div>
                        <select name="payment" class="custom-select">
                            <option value="cash">เงินสด</option>
                            <option value="credit_card">บัตรเครดิต</option>
                            <option value="PayPal">เพย์พาล</option>
                        </select>
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">วันที่หมดอายุ :</span>
                        </div>
                        <input type="date" class="form-control" name="date_expiry" value="2024-10-20">
                    </div>

                    <div class="form-group mb-1">
                        <label>หมายเหตุฯ</label>
                        <textarea class="form-control" name="comment" rows="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem repellendus earum cumque?</textarea>
                    </div>
                    <input type="text" name="method"  value="topup">

                    <button class="btn btn-success col"><i class="fas fa-database"></i> | บันทึกข้อมูล</button>
                </form>
            </div>

        @endif


        @if (session('topup'))
            <script>
                Swal.fire({
                    title: "Good job!",
                    text: "{{ session('topup') }}",
                    icon: "success"
                });
            </script>
        @endif

    </div>

    <div class="col-8 p-2">
        @if (session('status'))
            {{-- <div class="row">
                <div class="col">
                    <div class="card p-2">
                        <div class="card-header">
                            ประวัติการเติมเงิน
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>หมายเลข</th>
                                        <th>จำนวนเงิน</th>
                                        <th>วันที่เติมเงิน</th>
                                        <th>วันหมดอายุบัตร</th>
                                        <th>ประเภทการจ่าย</th>
                                        <th>เช็ค</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                        @foreach ( session('code') as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->card }}</td>
                                                <td>{{ number_format($item->total,2) }}</td>
                                                <td>{{ date('d-m-Y',strtotime($item->created_at)) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->date_expiry)->format('D j M y') }}</td>
                                                <td>{{ $item->method }}</td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-success">
                                                        <i class="fas fa-binoculars"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col">
                    <div class="card p-2">
                        <div class="card-header">
                            ประวัติการใช้งาน
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>หมายเลข</th>
                                        <th>จำนวนเงิน</th>
                                        <th>วันที่เติมเงิน</th>
                                        <th>วันหมดอายุบัตร</th>
                                        <th>ประเภทการใช้งาน</th>
                                        <th>ผู้ใช้งาน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach (session('topopDetail') as $t)
                                       <tr>
                                            <td>{{ $t->id }}</td>
                                            <td>{{ $t->card }}</td>
                                            <td>{{ number_format($t->total,2)}}</td>
                                            <td>{{ date('d-m-Y',strtotime($t->created_at)) }}</td>
                                            <td>{{ date('d-m-Y',strtotime($t->date_expiry)) }}</td>
                                            <td>{{ $t->method }}</td>
                                            <td>{{ $t->user }}</td>
                                       </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>



@endsection


