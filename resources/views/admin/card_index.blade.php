@extends('admin.layout')

@section('title','Card Register page')
@section('content')

<div class="row">

    <div class="col-4 p-2">
        <div class="card p-2">
            <div class="card-header bg-dark"><h3>Card Register</h3></div>
            <div class="card-body">
                <form action="{{ route('admin.card_create') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Card :</span>
                        </div>
                        <input type="number" class="form-control" autofocus name="card" value="{{ session('card') }}">
                    </div>
                        @error('card')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                </form>
            </div>
        </div>

        @if (session('card'))
            <div class="card p-2">
                <form action="{{ route('admin.card_store') }}" method="post">
                    @csrf
                    {{-- หมายเลขบัตร --}}
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Card :</label>
                        </div>
                        <input type="text" class="form-control" readonly name="card" value="{{ session('card') }}" >
                    </div>
                    {{-- Status --}}
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Status :</span>
                        </div>
                        <select class="custom-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Off</option>
                        </select>
                    </div>
                    {{-- Group --}}
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Group :</span>
                        </div>
                        <select class="custom-select" name="code">
                            <option value="1">Private card</option>
                            <option value="2">Meal card</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success col">SAVE</button>
                </form>
            </div>
        @endif

    </div>

    <div class="col-8 p-2">
        <div class="card p-2">
            <table class="table table-hover" id="example1">
                <thead class="thead-dark">
                    <tr>
                        <th>ลำดับที่</th>
                        <th>หมายเลข</th>
                        <th>วันที่ลงทะเบียน</th>
                        <th>สถานะ</th>
                        <th>หมวดหมู่</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->card }}</td>
                            <td>{{ $item->created_at }}</td>
                                {{-- สถานะ --}}
                                @if ( $item->status == 1)
                                    <td>
                                        <button class="btn btn-success" type="button" style="width: 90px; height: 35px;">
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" style="float: left;"></span>
                                            Active
                                        </button>
                                    </td>
                                @else
                                    <td>
                                        <button class="btn btn-danger" type="button" style="width: 90px; height: 35px;">
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" style="float: left;"></span>
                                             Off
                                        </button>
                                    </td>
                                @endif
                                {{-- เช็คประเภท --}}
                                @if ($item->code == 1)
                                    <td>Private card</td>
                                @else
                                    <td>Meal card</td>
                                @endif
                            <td>
                                <form id="delete-form-{{ $item->id }}" method="POST" action="{{ route('admin.card_destroy',$item->id) }}">                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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

@endsection


