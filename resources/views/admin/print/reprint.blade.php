<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>re_print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            margin: 0;
            padding: 0;
        }
        #t,p{
            font-size: 11px
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
        span{
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    
    <div class="container-fluid">

        <div class="row">
            <div class="col mx-auto p-2">

                <div class="row mb-2">
                    <div class="col text-center">
                        <img src="{{ asset('images/logo/logo.png') }}" height="60px" width="60px">
                    </div>
                </div>

                <div id="h" class="row">
                    <div class="col text-center">TIGER MUAYTHAI ( TA-IAD PHUKET )</div>
                </div>
                {{-- <div class="row">
                    <span>Print again</span>
                </div> --}}
                <hr>
    
                @php
                    $sum = 0;
                @endphp
                @foreach ($data as  $item)
                    <div class="row">
                        <div id="t" class="col">{{ $item->name }} จำนวน : {{ $item->qty }}</div>
                        <div id="t" class="col text-end">{{ number_format($item->qty * $item->price,2) }}</div>
                    </div>
                    @php
                        $sum += $item->qty * $item->price;
                    @endphp
                @endforeach

                <div class="row">
                    <div id="t" class="col">ราคาสินค้ารวม :</div>
                    <div id="t" class="col text-end">{{ number_format($sum,2) }}</div>
                </div>

                @if ($data[0]->discount != 0)
                    <div class="row">
                        <div id="t" class="col">ส่วนลด : {{ $data[0]->discount }} %</div>
                        <div id="t" class="col text-end">{{ number_format($data[0]->net_discount,2) }}</div>
                    </div>
                    <div class="row">
                        <div id="t" class="col">ลบส่วนลดแล้วคงเหลือ : </div>
                        <div id="t" class="col text-end">{{ number_format($data[0]->sub_discount,2) }}</div>
                    </div>
                @endif

                @if ($data[0]->vat7 == 7)
                    @php
                        $vat = 7
                    @endphp
                @else
                    @php
                        $vat = 3
                    @endphp
                @endif

                <div class="row">
                    <div id="t" class="col">ภาษีมูลค่าเพื่ม : {{ $vat }} %</div>
                    <div id="t" class="col text-end">{{ number_format($data[0]->net,2) }}</div>
                </div>
            
                <div class="row">
                    <div id="t" class="col text-left">ยอดรวม</div>
                    <div id="t" class="col text-end">{{ number_format($data[0]->ototal,2) }}</div>
                </div>
                <hr>

                <div class="row">
                    <div id="t" class="col">หมายเลขบิล : </div>
                    <div id="t" class="col text-end">{{ $data[0]->num_bill }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">หมายเลขบัตร</div>
                    <div id="t" class="col text-end">{{ $data[0]->code }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">จ่ายด้วย :</div>
                    <div id="t" class="col text-end">{{ $data[0]->payment }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">เริ่ม :{{ $data[0]->sta_date }}</div>
                    <div id="t" class="col text-end">หมดเวลา : {{ $data[0]->exp_date }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">ชื่อลูกค้า :</div>
                    <div id="t" class="col text-end">{{ $data[0]->fname }}</div>
                </div>
                <hr>

                <div class="row">
                    <p id="t">{{ $data[0]->comment }}</p>
                </div>
                <hr>

                <div class="row mb-3">
                    <div class="col text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=1234567899876543231" width="80" height="80">
                    </div>
                </div>
                <p>Please scan this QR code or show it to the staff for access.</p>
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
         window.location.href = "{{ route('admin.report_ticket') }}";
     }, 1000);
</script>
