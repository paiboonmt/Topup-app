@extends('admin.layout')
@section('title', 'Topup show card')
@section('content')

    <div class="row">
        <div class="col-6 mx-auto p-1">
            <div class="card">
                <div class="card-header bg-success">
                    <h2>ตรวจสอบการใช้งาน</h2>
                </div>
                <div class="card-body">
                
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">หมายเลขบัตร</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->card }}">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">จำนวนเงิน</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->price }}">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">จำนวนส่วนลด</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->discount }}">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">วิธีการจ่าย</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->payment }}">
                    </div>

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">วันที่ทำรายการ</span>
                        </div>
                        <input type="text" class="form-control" value="{{ date('d/m/Y - H:i:s' , strtotime($data[0]->created_at)) }}">
                    </div>
                    
                    @if ($data[0]->method == 'topup')
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">ประเภทการทำรายการ</span>
                            </div>
                            <input type="text" class="form-control" value="เติมเงิน">
                        </div>
                    @else
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">ประเภทการทำรายการ</span>
                            </div>
                            <input type="text" class="form-control" value="กดเงินเข้าระบบ">
                        </div>
                    @endif

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ผู้ทำรายการ</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $data[0]->user }}">
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.topup_index') }}" class="form-control btn btn-dark">ย้อนกลับ</a>
                </div>
            </div>

        </div>
    </div>

@endsection
