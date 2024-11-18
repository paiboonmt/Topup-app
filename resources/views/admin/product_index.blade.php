@extends('admin.layout')
@section('title', 'Product')

@section('content')
    <div class="row">
        <div class="col-12 p-2">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col-8">
                            <h2>Products</h2>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create">เพื่มสินค้า</button>
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
                                    <form action="{{ route('admin.product_create') }}" method="post">
                                        @csrf
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ชื่อสินค้า</span>
                                            </div>
                                            <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อสินค้า">
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ราคา</span>
                                            </div>
                                            <input type="number" class="form-control" name="price" placeholder="ป้อนชื่อสินค้า">
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
