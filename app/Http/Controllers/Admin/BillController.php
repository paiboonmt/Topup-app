<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function index( string $code ) {
        $data = DB::table('orders')
        ->join('order_details' , 'orders.code' , '=' , 'order_details.order_id' )
        ->join('products' ,'order_details.product_id' , '=' , 'products.id')
        ->select('orders.*', 'orders.total AS ototal' ,'order_details.*' , 'products.*')
        ->where('orders.code',$code)
        ->get();
        return view('admin.bill.edit_bill',['data' => $data]);
    }

    public function remove_item_bill( string $code , string $id) {

        if (empty($code) || empty($id)) {
            return redirect()->back()->withErrors('Invalid order or product ID.');
        }

        $deleted = DB::table('order_details')
            ->where('order_id', $code)
            ->where('product_id', $id)
            ->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Order detail deleted successfully.');
        }
    
        return redirect()->back()->withErrors('Failed to delete order detail. It may not exist.');
    }
}
