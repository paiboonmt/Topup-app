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
        ->select('orders.*', 'orders.total AS ototal' ,'order_details.*', 'order_details.quantity AS oqut' , 'products.*')
        ->where('orders.code',$code)
        ->get();
        $payment = DB::table('payments')->get();
        return view('admin.bill.edit_bill',['data' => $data , 'payment' => $payment]);
    }

    public function addItem(Request $request) {
        dd($request);
    }

    public function remove_item_bill( string $code , string $id ) {

        if (empty($code) || empty($id)) {
            return redirect()->back()->withErrors('Invalid order or product ID.');
        }

        if ( !empty($code) || !empty($id) ) {

            $count = DB::table('order_details')
            ->where( 'order_id' , $code )
            ->count();

            if ( $count == 1 ) {
                return redirect()->back()->with('msgerror', 'ไม่สามารถลบรายการได้ เพราะมีรายการเดียว !');
            } 

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

    public function removeVat( string $code , string $id){

        // dd($code,$id);

        if ( $id == 7) {
            $deleted = DB::table('orders')
            ->where('code',$code)
            ->where('vat7',$id)
            ->update([
                'vat7' => 0,
                'net'  => 0 
            ]);
        } else if ( $id == 3) {
            $deleted = DB::table('orders')
            ->where('code',$code)
            ->where('vat3',$id)
            ->update([
                'vat3' => 0,
                'net'  => 0 
            ]);
        }


        if ($deleted) {
            return redirect()->back();
        }
        return redirect()->back()->withErrors('Failed to delete order detail. It may not exist.');

        // return redirect()->back();
    }

    public function remove_discount( string $code ) {
        // dd($code);

        $data = DB::table('orders')
        ->where('code',$code)
        ->get();

        foreach ($data as $key => $value) {
            $total = $value->total;
            $discount = $value->net_discount;
        }

        $total = $total + $discount;

        // dd($total);


        $deleted = DB::table('orders')
            ->where('code',$code)
            ->update([
                'discount' => 0,
                'net_discount' => 0,
                'sub_discount' => 0,
                'net' => 0,
                'total' => $total
            ]);

        if ($deleted) {
            return redirect()->back();
        }
        return redirect()->back()->withErrors('Failed to delete order detail. It may not exist.');
    }

    public function update(Request $request , string $code) {

        $data = DB::table('orders')
        ->where('code',$code)
        ->get();

        foreach ($data as $key => $value) {
            $total = $value->total;
            $discount = $value->net_discount;
        }

        dd($total,$discount);

        // "totel" => "800"
        // "sum" => "800.00"
        // "code" => "1735788594"
        // "num_bill" => "2012025101"
        // "fname" => "John Andersion"
        // "payment" => "Cash|7"
        // "sta_date" => "2025-01-02"
        // "exp_date" => "2025-01-02"
    }
}
