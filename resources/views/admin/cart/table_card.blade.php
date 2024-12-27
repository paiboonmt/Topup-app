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
                    @foreach (session('cart', []) as $id => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-right">{{ number_format($item['price'], 2) }}</td>
                            <td class="text-right">{{ $item['quantity'] }}</td>
                            <td class="text-right">{{ number_format($item['price'] * $item['quantity'], 2) }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.removeItem', $item['id']) }}"
                                    class="btn btn-sm btn-danger" onclick="return confirm('ลบสินค้า')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="font-weight: 900">ยอดรวม :</td>
                        <td></td>
                        <td></td>
                        <td class="text-right" style="font-weight: 900; color: red">
                            {{ number_format($total, 2) }}</td>
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
                <input type="text" class="form-control" name="num_bill" readonly
                    value="{{ $setNum_bill }}">
            </div>

            {{-- หมายเลขบัตร --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text">หมายเลขบัตร | Qr Number</span>
                </div>
                <input type="text" class="form-control" name="code" readonly
                    value="{{ $codeNumber }}">
            </div>

            {{-- ส่วนลด --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text">ส่วนลด | Discount</span>
                </div>
                <select class="custom-select" name="discount">
                    @foreach ($discounts as $discount)
                        <option value="{{ $discount->discount_type . '|' . $discount->discount_value }}">
                            {{ $discount->discount_type }}</option>
                    @endforeach
                </select>
            </div>

            {{-- ประเภทการจ่าย --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text">ประเภทการจ่าย | Payment</span>
                </div>
                <select class="custom-select" name="payment" id="payment"
                    onchange="hideSelectedOption(this)">

                    @foreach ($payments as $payment)
                        <option value="{{ $payment->name . '|' . $payment->value }}">{{ $payment->name }}
                        </option>
                    @endforeach

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
                <textarea rows="3" class="form-control" placeholder="Comment" name="comment">ความสุขคือเมื่อสิ่งที่คุณคิด สิ่งที่คุณพูด และสิ่งที่คุณทำนั้นเป็นไปในทางเดียวกัน</textarea>
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