@extends('admin.layout')
@section('title', 'จัดการสินค้า ')
@section('content')
    <div class="row">
        <div class="col-12 p-2">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col">
                            <h4>Products | สินค้าและบริการ</h4>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create"
                                style="float: right; width:200px">เพื่มสินค้า</button>
                        </div>
                    </div>
                    <div class="modal fade" id="create" data-backdrop="static" data-keyboard="false" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.product_create') }}" method="post">
                                        @csrf
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ชื่อสินค้า</span>
                                            </div>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="ป้อนชื่อสินค้า">
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ราคา</span>
                                            </div>
                                            <input type="number" class="form-control" name="price"
                                                placeholder="ป้อนชื่อสินค้า">
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ออก</button>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm" id="product">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับที่</th>
                                <th scope="col">ชื่อสินค้า</th>
                                <th scope="col" class="text-right">ราคา</th>
                                <th scope="col" class="text-right">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 1;
                            @endphp
                            @foreach ($products as $i)
                                <tr>
                                    <td>{{ $t++ }}</td>
                                    <td>{{ $i->name }}</td>
                                    <td class="text-right">{{ $i->price }}</td>
                                    <td class="text-right">
                                        <form id="delete-form-{{ $i->id }}" method="POST"
                                            action="{{ route('admin.product_delete', $i->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#edit{{ $i->id }}"><i class="fas fa-edit"></i></button>
                                            <input type="hidden" name="id" value="{{ $i->id }}">
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $i->id }}, '{{ $i->name }}')"><i
                                                    class="fas fa-trash-restore"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- แก้ไข --}}
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

                                            <div class="modal-body">
                                                <form action="{{ route('admin.product_update') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">ชื่อสินค้า</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $i->name }}">
                                                    </div>

                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">ราคา</span>
                                                        </div>
                                                        <input type="number" class="form-control" name="price"
                                                            value="{{ $i->price }}">
                                                    </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">ออก</button>
                                                <button type="submit" class="btn btn-primary">อัปเดท</button>
                                            </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- แก้ไข --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'คุณแน่ใจแล้วใช่ไหม?',
                text: "ลบรายการ :" + name,
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


