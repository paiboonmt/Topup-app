<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ticket()
    {
        $data = DB::table('orders as or')
        ->join('order_details as od', 'or.code', '=', 'od.order_id')
        ->join('products as p', 'od.product_id', '=', 'p.id')
        ->select('or.code',
            DB::raw('MAX(od.order_id) as order_id'), 
            DB::raw('MAX(or.num_bill) as num_bill'),
            DB::raw('MAX(or.fname ) as fname '),
            DB::raw('MAX(or.discount) as discount'),
            DB::raw('MAX(or.net_discount) as net_discount'),
            DB::raw('MAX(or.vat7) as vat7'),
            DB::raw('MAX(or.vat3) as vat3'),
            DB::raw('MAX(or.net) as net'),
            DB::raw('MAX(or.total) as total'),
            DB::raw('MAX(or.payment) as payment'),
            DB::raw('MAX(or.user) as user')
        )
        ->whereDate('or.created_at', Carbon::today())  
        ->groupBy('or.code')
        ->orderByDesc('or.code')
        ->get();

        return view('admin.report.report_ticket',['data' => $data ]);
    }

    public function rePrintTicket( string $code)
    {      
        $data = DB::table('orders')
        ->join('order_details' , 'orders.code' , '=' , 'order_details.order_id' )
        ->join('products' ,'order_details.product_id' , '=' , 'products.id')
        ->select('orders.*', 'orders.total AS ototal' ,'order_details.*', 'order_details.quantity AS qty' , 'products.*')
        ->where('orders.code',$code)
        ->get();
        return view('admin.print.reprint',compact('data'));
    }

    public function reportDelete( string $code )
    {
        $order = DB::table('orders')->where('code',$code)->delete();
        $order_detail = DB::table('order_details')->where('order_id',$code)->delete();
        return to_route('admin.report_ticket');
    }
}
