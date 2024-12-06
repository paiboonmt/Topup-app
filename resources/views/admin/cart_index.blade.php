@extends('admin.layout')
@section('title', 'Cart page')

@section('content')

    <div class="row p-1">

        <div class="col-6">
            <div class="card p-2">
                <table class="table" id="cart">
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
                                <td class="text-left">{{ number_format($i->price,2) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-backdrop="static"
                                        data-keyboard="false" data-toggle="modal" data-target="#item{{ $i->id }}">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </td>
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
                                                        <input type="text" readonly class="form-control" name="name" value="{{ $i->name }}">
                                                    </div>

                                                    <div class="input-group mb-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">ราคา</span>
                                                        </div>
                                                        <input type="number" readonly class="form-control" name="price" value="{{ $i->price }}">
                                                    </div>

                                                    <div class="input-group mb-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">จำนวน</span>
                                                        </div>
                                                        <input type="number" class="form-control" name="quantity" value="{{ $i->quantity }}" min="1">
                                                    </div>

                                                    <input type="hidden" name="id" value="{{ $i->id }}">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"data-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit" class="btn btn-primary">เพื่มสินค้า</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-6">
            <div class="card p-2">
                @if (Session::has('cart') && count(Session::get('cart')) > 0)

                    <form action="{{ route('admin.checkOut') }}" method="post">
                        @csrf
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left">สินค้า</th>
                                    <th class="text-right">ราคา</th>
                                    <th class="text-right">จำนวน</th>
                                    <th class="text-right">รวม</th>
                                    <th class="text-right">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('cart',[]) as $id => $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-right">{{ number_format($item['price'],2) }}</td>
                                        <td class="text-right">{{ $item['quantity'] }}</td>
                                        <td class="text-right">{{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.removeItem', $item['id'] ) }}" class="btn btn-sm btn-danger"
                                                onclick="return confirm('ลบสินค้า')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="font-weight: 900">ยอดรวม :</td>
                                    <td colspan="2"></td>
                                    <td class="text-right" style="font-weight: 900; color: red">{{ number_format($total, 2) }}</td>
                                    <td class="text-center">บาท</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- ราคารวมของสินค้า --}}
                        <input type="hidden" name="total" value="{{ $total }}">

                        {{-- หมายเลขบิล --}}
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">หมายเลขบิล | Bill Number</span>
                            </div>
                            <input type="text" class="form-control" name="num_bill" readonly value="{{ $setNum_bill }}">
                        </div>

                        {{-- หมายเลขบัตร --}}
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">หมายเลขบัตร | Qr Number</span>
                            </div>
                            <input type="text" class="form-control" name="code" readonly value="{{ $codeNumber }}">
                        </div>

                        {{-- ส่วนลด --}}
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">ส่วนลด | Discount</span>
                            </div>
                            <select class="custom-select" name="discount">
                                <option value="0">0 %</option>
                                <option value="3">3 %</option>
                                <option value="5">5 %</option>
                            </select>
                        </div>

                        {{-- ประเภทการจ่าย --}}
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">ประเภทการจ่าย | Payment</span>
                            </div>
                            <select class="custom-select" name="payment" id="payment" onchange="hideSelectedOption(this)">
                                <option value="cash">เงินสด</option>
                                <option value="credit_card">บัตรเครดิต</option>
                                <option value="monney_card">บัตรแทนเงินสด</option>
                            </select>
                            <script>
                                function hideSelectedOption(selectElement) {
                                    const options = selectElement.options;
                                    // Loop through options and toggle their visibility
                                    for (let i = 0; i < options.length; i++) {
                                        if (options[i].value === selectElement.value) {
                                            options[i].style.display = 'none'; // Hide selected option
                                        } else {
                                            options[i].style.display = ''; // Show other options
                                        }
                                    }
                                }
                            </script>
                        </div>

                        {{-- วันที่ซื้อ และวันหมดอายุ --}}
                        <div class="row mb-1">
                            <div class="input-group col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">วันที่ซื้อ</span>
                                </div>
                                <input type="date" class="form-control" name="staDate" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="input-group col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">วันสิ้นสุด</span>
                                </div>
                                <input type="date" class="form-control" name="expDate" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        {{-- ชื่อลูกค้า --}}
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">ชื่อลูกค้า</span>
                            </div>
                            <input type="text" class="form-control" name="customerName" value="John Andersion">
                        </div>

                        {{-- หมายเหตุ --}}
                        <div class="input-group mb-1">
                            <textarea rows="3" 
                            class="form-control" 
                            placeholder="Comment"  
                            name="comment">ความสุขคือเมื่อสิ่งที่คุณคิด สิ่งที่คุณพูด และสิ่งที่คุณทำนั้นเป็นไปในทางเดียวกัน</textarea>
                        </div>

                        {{-- ปุ่มกดยกเลิก และขายสินค้า  --}}
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('admin.cancelCart') }}" class="btn btn-danger form-control">ยกเลิก</a>
                            </div>
                            <div class="col">
                                {{-- <a href="" class="btn btn-success form-control">ขายสินค้า</a> --}}
                                <button type="submit" class="btn btn-success form-control">ขายสินค้า</button>
                            </div>
                        </div>

                    </form>
                    
                @else
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="text-left">สินค้า</th>
                                <th class="text-right">ราคา</th>
                                <th class="text-right">จำนวน</th>
                                <th class="text-right">รวม</th>
                                <th class="text-right">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ไม่มีสินค้าในตะกร้า</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>

@endsection
