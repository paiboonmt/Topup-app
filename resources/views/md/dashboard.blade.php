@extends('md.layout')

@section('title', 'Dashboard')

@section('content')

    <div class="row p-1">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($ticket[0]->total_sum ,2 ) }}</h3>
                    <p>รายรับวันนี้</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">รายงาน <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
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
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $total->quantity }}</h3>
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
                    <h3>{{ $product }}</h3>
                    <p>จำนวนการขาย packages</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">รายงาน <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row p-1">
        <div class="col-lg-4 col-12">
            <div class="card p-1">
                <div class="card-header bg-info">รายการขายประจำวัน</div>
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>วันที่</th>
                            <th class="text-right">จำนวนรายได้</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>21/10/24</td>
                            <td class="text-right">3,000,000.00</td>
                        </tr>
                        <tr>
                            <td>20/10/24</td>
                            <td class="text-right">2,000,000.00</td>
                        </tr>
                        <tr>
                            <td>19/10/24</td>
                            <td class="text-right">1,000,000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header bg-dark">ประเภทการจ่าย</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ประเภท</th>
                            <th>ครั้ง</th>
                            <th class="text-right">ยอดรวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cash</td>
                            <td>100</td>
                            <td class="text-right">50,000.00</td>
                        </tr>
                        <tr>
                            <td>Paypal</td>
                            <td>50</td>
                            <td class="text-right">100,000.00</td>
                        </tr>
                        <tr>
                            <td>Visa card</td>
                            <td>20</td>
                            <td class="text-right">35,000.00</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header" style="background-color: rgb(241, 221, 41)">แพ็คเกจขายดี</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ชื่อแพ็คเกจ</th>
                            <th class="text-right">จำนวนครั้ง / ขาย</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Drop in</td>
                            <td class="text-right">11</td>
                        </tr>
                        <tr>
                            <td>Private Muaythai</td>
                            <td class="text-right">9</td>
                        </tr>
                        <tr>
                            <td>Day Pass</td>
                            <td class="text-right">5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
