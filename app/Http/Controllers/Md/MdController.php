<?php

namespace App\Http\Controllers\Md;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MdController extends Controller
{

    public function calculateRevenueChange($yesterdayRevenue, $todayRevenue)
    {
        // ตรวจสอบว่ารายรับเมื่อวานเป็น 0 เพื่อหลีกเลี่ยงการหารด้วย 0
        if ($yesterdayRevenue == 0) {
            return $todayRevenue > 0 ? 100 : 0; // หากรายรับเมื่อวานเป็น 0 แล้ววันนี้ขายได้ ให้แสดงผลเป็น 100%
        }

        // คำนวณเปอร์เซ็นต์การเปลี่ยนแปลง
        $percentageChange = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;

        return $percentageChange;
    }

    public function index()
    {
        // ticket
        $date = date('Y-m-d');
        $ticket = DB::table('orders')
            ->select(DB::raw('SUM(total) as total_sum'))
            ->where('date', 'like', '%' . $date .'%')
            ->get();
        $yesterdayRevenue = DB::table('orders')
            ->whereDate('date', Carbon::yesterday())
            ->sum('total');
        $todayRevenue = DB::table('orders')
            ->whereDate('date', Carbon::today())
            ->sum('total');
        $percentageChange = $this->calculateRevenueChange($yesterdayRevenue, $todayRevenue);

        $total = DB::table('totel')
            ->select('quantity')
            ->orderByDesc('id')->first();

        $product = DB::table('orders')
            ->whereDate('date' , Carbon::today())
            ->count();

        return view('md.dashboard',
            [
                'ticket'            => $ticket,
                'yesterdayRevenue'  => $yesterdayRevenue,
                'todayRevenue'      => $todayRevenue,
                'percentageChange'  => $percentageChange,
                'total'             => $total,
                'product'           => $product,
            ]
        );
    }

    public function report_daily()
    {
        return view('md.report_daily');
    }

    public function report_ticket()
    {
        return view('md.report_ticket');
    }

    public function report_summary()
    {
        return view('md.report_summary');
    }

    public function report_checkin()
    {
        return view('md.report_checkin');
    }
}
