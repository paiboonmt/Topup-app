@extends('admin.layout')

@section('title','Trainer page')

@section('content')

{{-- Button Create --}}

<div class="row py-2">
    <div class="col-12">
        <a href="{{ route('admin.trainer_create') }}" class="btn btn-success">Create Trainer</a>
    </div>
</div>

{{-- Data --}}
    <div class="row py-2">
        <div class="col-12">
            <div class="card p-2">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>phone</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Create_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>

                                @if ($item->status == 1)
                                    <td>
                                        <button class="btn btn-success" type="button">
                                        <span class="spinner-grow-sm"></span>
                                            Active
                                        </button>
                                    </td>
                                @else
                                    <td>
                                        <button class="btn btn-primary" type="button" disabled>
                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </button>
                                    </td>
                                @endif

                                <td>
                                    <img src="{{ asset('images/trainer/'.$item->image) }}" width="50px">
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <form id="delete-form-{{ $item->id }}" method="POST" action="{{ route('admin.trainer_destroy',$item->id) }}">
                                        <a href="{{ route('admin.trainer_show',$item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        @csrf
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
