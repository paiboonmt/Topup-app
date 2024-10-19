@extends('admin.layout')

@section('title','Topup show page')

@section('content')

    <div class="row">
        <div class="col py-2">
            <div class="card p-2">
                <table class="table table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>หมายเลขการ์ด</th>
                            <th>ราคารวม</th>
                            <th>ประเภทการชำระ</th>
                            <th>วันที่เติมเงิน</th>
                            <th>วันที่หมดอายุ</th>
                            <th>รูปแบบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                            $date = date('Y-m-d')
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->card }}</td>
                                <td>{{ $item->total }}</td>
                                <td>{{ $item->payment }}</td>
                                <td>{{ $item->created_at }}</td>

                                @if ( $item->date_expiry >= $date )
                                    <td>
                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">                                    </td>
                                @elseif ( $item->date_expiry < $date )
                                    <td>
                                        <input type="checkbox"  data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                @endif

                                <td>{{ $item->method }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
