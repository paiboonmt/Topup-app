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
            if ($orderS -> successful()) {
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
            if ($totalData->successful()) {
                $countTotal  = json_decode($totalData->body(),true);
            }

        $DatacountCustomer = Http::get('http://172.16.0.132:8000/api/countCustomer');
            if ($DatacountCustomer->successful()) {
                $DatacountCustomer  = json_decode($DatacountCustomer->body(),true);
            }

        // Table
        $sumOrders = Http::get('http://172.16.0.132:8000/api/sumOrders');
            if($sumOrders->successful()){
                $sumOrders = json_decode($sumOrders->body(),true);
            }
        $countProducts = Http::get('http://172.16.0.132:8000/api/countProducts');
            if($countProducts->successful()){
                $countProducts = json_decode($countProducts->body(),true);
            }
        $countPayment = Http::get('http://172.16.0.132:8000/api/countPayment');
            if($countPayment->successful()){
                $countPayment = json_decode($countPayment->body(),true);
            }

        $rr = DB::connection('mysql2')->table('orders')
            ->select(DB::raw('DATE(`date`) as date'), DB::raw('SUM(total) as sum'))
            ->groupBy(DB::raw('DATE(`date`)'))
            ->orderBy('date', 'desc')
            ->limit(5)  // Add the desired limit here
            ->get();
        $tt = DB::connection('mysql2')->table('orders')
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->select('order_details.product_name', DB::raw('COUNT(order_details.product_name) as ccount'), DB::raw('SUM(orders.total) as sum'))
            ->whereDate('orders.date', 'like', "%$date%")
            ->groupBy('order_details.product_name')
            ->orderBy('ccount', 'desc')
            ->limit(5)
            ->get();


        return view('md.dashboard',
            [
                'ticket'            => $ticket,
                'yesterdayRevenue'  => $yesterdayRevenue,
                'todayRevenue'      => $todayRevenue,
                'percentageChange'  => $percentageChange,
                'product'           => $product,
                'totalSale'         => $totalSale,
                'countTotal'        => $countTotal,
                'DatacountCustomer' => $DatacountCustomer,
                'sumOrders'         => $sumOrders,
                'countProducts'     => $countProducts,
                'countPayment'      => $countPayment,
                'rr'                => $rr,
                'tt'                => $tt,
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
