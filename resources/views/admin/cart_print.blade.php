<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        #t{
            font-size: 10px
        }
        #h{
            font-size: 12px;
            font-weight: bold;
        }
        .text-end{
            padding-right: 35px;
        }
        hr{
            border-bottom: 2px dotted;
        }
    </style>
</head>

<body>

    <div class="container-fluid">

        <div class="row">
            <div class="col mx-auto p-2">
                <div class="row">
                    <div class="col text-center">
                        <img src="{{ asset('images/logo/logo.png') }}" height="60px" width="60px">
                    </div>
                </div>

                <div id="h" class="row">
                    <div class="col text-center">TIGER MUAY THAI ( TA-IAD PHUKET )</div>
                </div>
                <hr>

                @php
                    $sum = 0;
                @endphp
                @foreach (session('cart') as $id => $item)
                    <div class="row">
                        <div id="t" class="col">{{ $item['name'] }} จำนวน : {{ $item['quantity'] }}</div>
                        <div id="t" class="col text-end">{{ number_format($item['quantity'] * $item['price'], 2) }}</div>
                    </div>
                    @php
                        $sum += $item['quantity'] * $item['price']
                    @endphp
                @endforeach

                <div class="row">
                    <div id="t" class="col">ราคาสินค้ารวม :</div>
                    <div id="t" class="col text-end">{{ number_format($sum,2) }}</div>
                </div>

                @if ($data['discount'] != 0)
                    <div class="row">
                        <div id="t" class="col">ส่วนลด : {{ $data['discount'] }} %</div>
                        <div id="t" class="col text-end">{{ number_format($data['netDiscount'],2) }}</div>
                    </div>
                    <div class="row">
                        <div id="t" class="col">ลบส่วนลดแล้วคงเหลือ : </div>
                        <div id="t" class="col text-end">{{ number_format($data['netTotal'],2) }}</div>
                    </div>
                @endif

                <div class="row">
                    <div id="t" class="col">ภาษีมูลค่าเพื่ม : {{ $data['net'] }} %</div>
                    <div id="t" class="col text-end">{{ number_format($data['vat'],2) }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col text-left">ยอดรวม</div>
                    <div id="t" class="col text-end">{{ number_format($data['total'], 2) }}</div>
                </div>
                <hr>

                <div class="row">
                    <div id="t" class="col">หมายเลขบิล : </div>
                    <div id="t" class="col text-end">{{ $data['num_bill'] }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">หมายเลขบัตร</div>
                    <div id="t" class="col text-end">{{ $data['code'] }}</div>
                </div>
          
                <div class="row">
                    <div id="t" class="col">จ่ายด้วย :</div>
                    <div id="t" class="col text-end">{{ $data['payment'] }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">เริ่ม :{{ $data['staDate'] }}</div>
                    <div id="t" class="col text-end">หมดเวลา : {{ $data['expDate'] }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">ชื่อลูกค้า :</div>
                    <div id="t" class="col text-end">{{ $data['customerName'] }}</div>
                </div>
                <hr>

                <div class="row">
                    <p id="t">{{ $data['comment'] }}</p>
                </div>
                <hr>

                <div class="row">
                    <div class="col text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $data['code'] }}" width="80" height="80">
                    </div>
                </div>
                <hr>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

<script>
    window.print();
    setTimeout(function() {
        window.location.href = "{{ route('admin.cart_index') }}";
    }, 1000);
</script>

@php
    Session::forget('cart');
@endphp
