@extends('admin.layout')
@section('title', 'Payment Page')

@section('content')
    <div class="row">
        <div class="col-12 p-2">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col">
                            <h2>Payments | วิธีการชำระ</h2>
                        </div>
                        <div class="col">
                            <button type="button" 
                                class="btn btn-success" 
                                data-toggle="modal" 
                                data-target="#create"
                                style="width: 200px; float: right;"
                            >เพื่มวิธีการชำระ</button>
                        </div>
                    </div>
                    <div class="modal fade" id="create" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ route('admin.payment_create') }}" method="post">
                                        @csrf

                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ชื่อ วิธีการชำระ</span>
                                            </div>
                                            <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อวิธีการชำระ" required>
                                        </div>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ค่าเปอร์เซน</span>
                                            </div>
                                            <input type="number" class="form-control" name="value" required>
                                        </div>

                                        <div class="p-2">
                                            <p style="color: red">ค่าเปอร์เซน เช่น : 3% , 5% , 7%</p>
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
                    <table class="table table-sm" id="example1">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับที่</th>
                                <th scope="col">ชื่อ วิธีการชำระ</th>
                                <th scope="col">ค่า เปอร์เซนภาษี</th>
                                <th scope="col">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 1;
                            @endphp 
                          @foreach ($data as $i)
                              <tr>
                                <td>{{ $t++ }}</td>
                                <td>{{ $i->name }}</td>
                                <td>{{ $i->value }} %</td>
                                <td>
                                    <form id="delete-form-{{ $i->id }}" method="POST" action="{{ route('admin.payment_destroy',$i->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit{{ $i->id }}">
                                            <i class="fas fa-edit">
                                        </i></button>
                                        <input type="hidden" name="id" value="{{ $i->id }}">
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $i->id }})">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </form>
                                </td>
                              </tr>

                              <div class="modal fade" id="edit{{ $i->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="{{ route('admin.payment_update') }}" method="post">
                                                @csrf
                                                
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">ไอดี</span>
                                                    </div>
                                                    <input type="text" readonly class="form-control" name="id" value="{{ $i->id }}">
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">ชื่อวิธีการชำระ</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="name" value="{{ $i->name }}">
                                                </div>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">ค่าเปอร์เซนภาษี</span>
                                                    </div>
                                                    <input type="number" class="form-control" name="value" value="{{ $i->value }}">
                                                </div>
                                            
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ออก</button>
                                            <button type="submit" class="btn btn-primary">อัปเดท</button>
                                        </div>

                                    </form> 
                                    </div>
                                </div>
                            </div>

                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmDelete(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! item id : " + id,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    } 
</script>
