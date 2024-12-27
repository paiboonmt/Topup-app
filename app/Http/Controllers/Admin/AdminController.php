<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesData = DB::table('orders')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // แปลงข้อมูลเป็นรูปแบบที่ใช้กับ Chart.js
        $data = [
            'labels' => $salesData->pluck('month')->map(function ($month) {
                return date("F", mktime(0, 0, 0, $month, 1)); // แปลงเลขเดือนเป็นชื่อเดือน
            }),
            'datasets' => [
                [
                    'label' => 'ยอดขายรายเดือน',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'data' => $salesData->pluck('total_sales'),
                ]
            ],
        ];
        return view('admin.dashboard', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
