<?php

namespace App\Http\Controllers\Md;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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

        $yesterdayRevenue = Http::get('http://172.16.0.132:8000/api/orders');
        if ( $yesterdayRevenue->successful() ) {
            $yesterdayRevenue = json_decode($yesterdayRevenue->body(),true);
            $yesterdayRevenue = $yesterdayRevenue['yesterdayRevenue'];
        }

        $todayRevenue = Http::get('http://172.16.0.132:8000/api/orders');
        if ( $todayRevenue->successful() ) {
            $todayRevenue = json_decode($todayRevenue->body(),true);
            $todayRevenue = $todayRevenue['todayRevenue'];
        }

        $percentageChange = $this->calculateRevenueChange($yesterdayRevenue , $todayRevenue );

        $product = DB::table('orders')->whereDate('date' , Carbon::today())->count();

        $orderS  = Http::get('http://172.16.0.132:8000/api/orders');
            if ($orderS -> successful()) 
            {
                // $data = $response->json();
                // แปลง JSON เป็น array
                $respone = json_decode($orderS->body(), true);
                $data = $respone['orders'];
                $rowCount = count($data);
                if (is_array($data)) {
                    $totalSale = array_sum(array_column($data,'total'));
                }
            }

        $totalData = Http::get('http://172.16.0.132:8000/api/totals');
            if ($totalData->successful())
            {
                // แปลง JSON เป็น array
                $countTotal  = json_decode($totalData->body(),true);
                // นับจำนวน row
                // $countTotal = count($total);
                // dd($countTotal);
            }

        $countCustomer = DB::table('member');

        return view('md.dashboard',
            [
                'ticket'            => $ticket,
                'yesterdayRevenue'  => $yesterdayRevenue,
                'todayRevenue'      => $todayRevenue,
                'percentageChange'  => $percentageChange,
                // 'total'             => $total,
                'product'           => $product,
                'totalSale'         => $totalSale,
                'countTotal'        => $countTotal,
                // 'orders'            => $data,
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
