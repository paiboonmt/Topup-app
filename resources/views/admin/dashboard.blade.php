@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-6 p-1">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4>รายงานยอดขาย</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart" width="100%"></canvas>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>

      
        <script>
            const data = @json($data);
            console.log(data);
            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // เปลี่ยนเป็น 'line', 'pie', 'doughnut', ฯลฯ
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    },
                },
            });
        </script>

@endsection
