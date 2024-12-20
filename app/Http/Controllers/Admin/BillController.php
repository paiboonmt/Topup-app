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

    public function update(Request $request , string $code) {
        dd($request);
    }
}
