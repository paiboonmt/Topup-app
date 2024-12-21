@extends('admin.layout')

@section('title', 'Discount')

@section('content')

    <div class="row p-1">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <div class="row">
                        <div class="col">
                            <h2>Discount</h2>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create"
                                style="float: right; width:200px">เพื่มสินค้า</button>
                            <div class="modal fade" id="create" data-backdrop="static" data-keyboard="false"
                                tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.discount_create') }}" method="post">
                                                @csrf
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">ส่วนลด</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="discount_type"
                                                        placeholder="ป้อนชื่อสินค้า" required>
                                                </div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">จำนวนส่วนลด</span>
                                                    </div>
                                                    <input type="number" class="form-control"
                                                        name="discount_value"placeholder="ป้อนจำนวนส่วนลด" required>
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">ออก</button>
                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ส่วนลด</th>
                                <th>จำนวนส่วนลด</th>
                                <th>แก้ไข</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->id }}</td>
                                    <td>{{ $discount->discount_type }}</td>
                                    <td>{{ $discount->discount_value }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#edit{{ $discount->id }}">แก้ไข</button>
                                        <div class="modal fade"
                                            id="edit{{ $discount->id }}" data-backdrop="static" data-keyboard="false"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div
                                                        class="modal-body
                                                        ">
                                                        <form
                                                            action="{{ route('admin.discount_update', ['id' => $discount->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">ส่วนลด</span>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                    name="discount_type"
                                                                    value="{{ $discount->discount_type }}" required>
                                                            </div>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">จำนวนส่วนลด</span>
                                                                </div>
                                                                <input type="number" class="form-control"
                                                                    name="discount_value"
                                                                    value="{{ $discount->discount_value }}" required>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">ออก</button>
                                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#delete{{ $discount->id }}">ลบ</button>
                                        <div class="modal fade
                                            "
                                            id="delete{{ $discount->id }}" data-backdrop="static" data-keyboard="false"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div
                                                        class="modal-body
                                                        ">
                                                        <form
                                                            action="{{ route('admin.discount_delete', ['id' => $discount->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <h3>คุณต้องการลบส่วนลดนี้ใช่หรือไม่</h3>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">ไม่ใช่</button>
                                                        <button type="submit" class="btn btn-primary">ใช่</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@endsection
