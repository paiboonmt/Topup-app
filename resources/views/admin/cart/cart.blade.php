<div class="card p-2">
    <table class="table table-sm cart ">
        <thead>
            <tr>
                <th scope="col">ชื่อสินค้า</th>
                <th scope="col">ราคาสินค้า</th>
                <th scope="col">เลือกสินค้า</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $i)
                <tr>
                    <td>{{ $i->name }}</td>
                    <td class="text-left">{{ number_format($i->price, 2) }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" data-backdrop="static"
                            data-keyboard="false" data-toggle="modal" data-target="#item{{ $i->id }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="item{{ $i->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.addItem') }}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">รายการสินค้า</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ชื่อสินค้า</span>
                                        </div>
                                        <input type="text" readonly class="form-control" name="name"
                                            value="{{ $i->name }}">
                                    </div>

                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ราคา</span>
                                        </div>
                                        <input type="number" readonly class="form-control" name="price"
                                            value="{{ $i->price }}">
                                    </div>

                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">จำนวน</span>
                                        </div>
                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ $i->quantity }}" min="1">
                                    </div>

                                    <input type="hidden" name="id" value="{{ $i->id }}">

                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                        class="btn btn-secondary"data-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">เพื่มสินค้า</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>