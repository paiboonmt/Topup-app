<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            #t{
                font-size: 12px
            }
            #h{
                font-size: 18px;
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
            <div class="col-12 p-2">

                <div id="h" class="row">
                    <div class="col text-center">TIGER MUAYTHAI (PHUKET)</div>
                    <hr>
                </div>
    
                @foreach ($data as  $item)
                    <div class="row">
                        <div id="t" class="col">{{ $item->name }} | จำนวน : {{ $item->qty }}</div>
                        <div id="t" class="col text-end">{{ number_format($item->qty * $item->price,2) }}</div>
                    </div>
                @endforeach

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
                    <div id="t" class="col">ส่วนลด</div>
                    <div id="t" class="col text-end">{{ $data[0]->discount }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">การจ่าย</div>
                    <div id="t" class="col text-end">{{ $data[0]->payment }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">เริ่ม :{{ $data[0]->sta_date }}</div>
                    <div id="t" class="col text-end">หมดเวลา : {{ $data[0]->exp_date }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">ชื่อ :</div>
                    <div id="t" class="col text-end">{{ $data[0]->fname }}</div>
                </div>
            <hr>
                <div class="row">
                    <p id="t">{{ $data[0]->comment }}</p>
                </div>

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
