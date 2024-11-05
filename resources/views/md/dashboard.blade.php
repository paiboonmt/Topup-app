@extends('md.layout')

@section('title', 'Dashboard')

@section('content')

    <div class="row p-1">
        {{-- แสดงรายรับ --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($totalSale ,2 ) }}</h3>
                    <p>รายรับวันนี้</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">รายงาน <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- แสดงเปอร์เซน --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($percentageChange,0) }}<sup style="font-size: 20px">%</sup></h3>
                    <p>เมื่อวาน | {{ number_format($yesterdayRevenue,2) }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">รายงาน <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- แสดงจำนวนลูกค้า --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3 id="dataDisplay">{{ $countTotal[0]['quantity'] }}</h3>
                    <p>จำนวนลูกค้าที่ใช้บริการวันนี้</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">รายงาน <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $DatacountCustomer }}</h3>
                    <p>จำนวนลูกค้า</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">รายงาน <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header bg-info">รายการขายประจำวัน</div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>วันที่</th>
                            <th class="text-right">จำนวนรายได้</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $sumOrders as $item )
                            <tr>
                                <td>{{ date('d-m-Y',strtotime($item['date'])) }}</td>
                                <td class="text-right">{{ number_format($item['sum'],2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header bg-dark">ประเภทการจ่าย</div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ประเภท</th>
                            <th>ครั้ง</th>
                            <th class="text-right">ยอดรวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countProducts as $item)
                            <tr>
                                <td>{{ $item['product_name'] }}</td>
                                <td>{{ $item['ccount'] }}</td>
                                <td class="text-right">{{ number_format($item['sum'],2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header" style="background-color: rgb(241, 221, 41)">แพ็คเกจขายดี</div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ชื่อแพ็คเกจ</th>
                            <th>จำนวน</th>
                            <th class="text-right">จำนวนครั้ง / ขาย</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($countPayment as $item)
                           <tr>
                                <td>{{ $item['pay'] }}</td>
                                <td>{{ $item['count'] }}</td>
                                <td class="text-right">{{ number_format($item['sum'],2) }}</td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header" style="background-color: rgb(8, 36, 174); color:white">Ratachai gym</div>
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>วันที่</th>
                            <th class="text-right">จำนวนรายได้</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($rr as $item)
                           <tr>
                                <td>{{ $item->date }}</td>
                                <td class="text-right">{{ number_format($item->sum,2) }}</td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header" style="background-color: rgb(147, 71, 177); color:white">Ratachai gym</div>
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>รายการ</th>
                            <th>จำนวน</th>
                            <th class="text-right">จำนวนรายได้</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($tt as $item)
                           <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->ccount }}</td>
                                <td class="text-right">{{ number_format($item->sum,2) }}</td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        // รีเฟรชหน้าเว็บทุก 120000ms (2 นาที)
        setInterval(function(){
            window.location.reload(); // ใช้ window.location.reload() เพื่อรีเฟรชหน้า
        }, 60000);
    </script>

@endsection
