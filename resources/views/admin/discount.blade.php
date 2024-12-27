@extends('admin.layout')

@section('title', 'Discount')

@section('content')
    <div class="row">
        <div class="col-12 p-2">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <div class="row">
                        <div class="col">
                            <h4>Discount | ส่วนลด</h4>
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
                    <table class="table table-sm " id="discount">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ส่วนลด</th>
                                <th class="text-right">จำนวนส่วนลด</th>
                                <th class="text-right">แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($discounts as $i)
                                <tr>
                                    <td>{{ $i->id }}</td>
                                    <td>{{ $i->discount_type }}</td>
                                    <td class="text-right">{{ $i->discount_value }}</td>
                                    <td class="text-right">
                                        <form action="" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#edit{{ $i->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $i->id }}, '{{ $i->discount_type }}')">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <div class="modal fade" id="edit{{ $i->id }}" data-backdrop="static"
                                        data-keyboard="false" tabindex="-1" aria-hidden="true">
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
                                                    <form action="{{ route('admin.discount_update', ['id' => $i->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">ส่วนลด</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="discount_type"
                                                                value="{{ $i->discount_type }}" required>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">จำนวนส่วนลด</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="discount_value"
                                                                value="{{ $i->discount_value }}" required>
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

    <script>
        function confirmDelete(id, discount_type) {
            Swal.fire({
                title: 'คุณแน่ใจแล้วใช่ไหม?',
                text: "ลบรายการ :" + discount_type,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ต้องการลบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

@endsection
