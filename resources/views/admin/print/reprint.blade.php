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
        </style>
</head>

<body>
    
    <div class="container-fluid">

        <div class="row">
            <div class="col-12 mx-auto">

                <div id="h" class="row">
                    <div class="col text-center">TIGER MUAYTHAI (PHUKET)</div>
                </div>
    
                @foreach ($data as  $item)
                    <div class="row">
                        <div id="t" class="col text-left">{{ $item->name }} | {{ $item->quantity }}</div>
                        <div id="t" class="col text-right">{{ number_format($item->price,2) }}</div>
                    </div>
                @endforeach

                <div class="row">
                    <div id="t" class="col text-left">ภาษีมูลค่าเพื่ม :</div>
                    <div id="t" class="col text-left">{{ number_format($data[0]->net,2) }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col text-left">ยอดรวม</div>
                    <div id="t" class="col text-left">{{ number_format($data[0]->total,2) }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">Tex : </div>
                    <div id="t" class="col">{{ $data[0]->num_bill }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">Code</div>
                    <div id="t" class="col">{{ $data[0]->code }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">Discount</div>
                    <div id="t" class="col">{{ $data[0]->discount }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">Payment</div>
                    <div id="t" class="col">{{ $data[0]->payment }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">Start :{{ $data[0]->sta_date }}</div>
                    <div id="t" class="col">End : {{ $data[0]->exp_date }}</div>
                </div>

                <div class="row">
                    <div id="t" class="col">Name :</div>
                    <div id="t" class="col">{{ $data[0]->fname }}</div>
                </div>

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
    // window.print();
    // setTimeout(function() {
    //     window.location.href = "{{ route('admin.cart_index') }}";
    // }, 1000);
</script>

{{-- @php
    Session::forget('cart');
@endphp  --}}