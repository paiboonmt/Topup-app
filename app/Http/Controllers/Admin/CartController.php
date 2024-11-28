<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $products = Product::all();
        //-------------------------------------
        $order = DB::table('orders')
            ->select('num_bill')
            ->where('created_at', 'LIKE', '%' . Carbon::today()->toDateString() . '%')
            ->count();

        if ( $order == 0 ) {
            $setNum_bill = date('dmY').+101;
        } else {
            $string = DB::table('orders')
                ->whereDate('created_at', Carbon::today())
                ->orderByDesc('id')
                ->first();
            // dd($string);
            $num_bill = intval($string->num_bill);
            $setNum_bill = $num_bill + 1 ;
            // dd($setNum_bill);
        }
        //-------------------------------------
        $codeNumber = round(microtime(true));
        //-------------------------------------

        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return view('admin.cart_index',
            [
                'products'      => $products,
                'setNum_bill'   => $setNum_bill,
                'cart'          => $cart,
                'total'         => $total,
                'codeNumber'    => $codeNumber
            ]    
        );
    }

    public function addItem(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->id;
        $quantity = $request->quantity;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $product = DB::table('products')->where('id',$productId)->first();
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }
        session()->put('cart', $cart);
        return to_route('admin.cart_index');
    }

    public function removeItem( $id )
    {
        $cart = session('cart', []);

        // ตรวจสอบว่ามีสินค้าใน cart หรือไม่
        if (isset($cart[$id])) {
            unset($cart[$id]); // ลบสินค้าออกจาก cart
            session(['cart' => $cart]); // อัปเดต cart ใน session
        }
        return redirect()->back();
    }

    public function cancelCart()
    {
        // dd(Session::all());
        Session::forget('cart');
        return redirect()->back();
    }

    public function checkOut( Request $request)
    {
        $request->validate(
            [
                'num_bill'      => 'required',
                'code'          => 'required|unique:orders,code',
                'payment'       => 'required',
                'customerName'  => 'required'
            ]
        );

        $total          = $request->total;
        $num_bill       = $request->num_bill;
        $code           = $request->code;
        $discount       = $request->discount;
        $payment        = $request->payment;
        $staDate        = $request->staDate;
        $expDate        = $request->expDate;
        $customerName   = $request->customerName;
        $comment        = $request->comment;

        session(['total' => $total]);
        session(['num_bill' => $num_bill]);
        session(['code' => $code]);
        session(['discount' => $discount]);
        session(['payment' => $payment]);
        session(['staDate' => $staDate]);
        session(['expDate' => $expDate]);
        session(['customerName' => $customerName]);
        session(['comment' => $comment]);

        if ( $discount != 0) {

        } 

        if ( $discount == 0) {

            if ( $payment == 'cash') {
                $net = 7;
                $vat = ( $total * 7 ) / 100 ;
            } elseif ( $payment == 'credit_card') {
                $net = 3;
                $vat = ( $total * 3 ) / 100 ;
            } elseif ( $payment == 'monney_card' ) {
                $net = 1;
                $vat = 1;
            }

            // dd( $total , $net , $vat );

            // บันทึกข้อมูล
            $order = new Order;
            $order->code        = $code;
            $order->num_bill    = $num_bill;
            $order->fname       = $customerName;
            $order->discount    = $discount;
           
            if ( $net == 7) 
            {
                $order->vat7        = $net;
                $order->vat3        = 0 ;
                $total              = $total+$vat;
            } 
            elseif ( $net == 3 ) 
            {
                $order->vat7        = 0;
                $order->vat3        = $net;
                $total              = $total+$vat;
            }
            
            $order->net         = $vat;
            $order->total       = $total;
            $order->payment     = $payment;
            $order->sta_date    = $staDate;
            $order->exp_date    = $expDate;
            $order->comment     = $comment;
            $order->user        = Auth::user()->name;
            $order->save();

        }

        $cart = session()->get('cart');
        foreach ($cart as $id => $item) {
          
            $d = new OrderDetail;
            $d->order_id        = $code; 
            $d->product_id      = $item['id'];
            $d->product_name    = $item['name'];
            $d->quantity        = $item['quantity'];
            $d->total           = $item['price'] * $item['quantity'] ;
            $d->date            = Carbon::today();

            $d->save();

        }

        // Session::forget('cart');

        // return to_route('admin.cart_index');

        $data = [
            'total'          => $request->total,
            'num_bill'       => $request->num_bill,
            'code'           => $request->code,
            'discount'       => $request->discount,
            'payment'        => $request->payment,
            'staDate'        => $request->staDate,
            'expDate'        => $request->expDate,
            'customerName'   => $request->customerName,
            'comment'        => $request->comment
        ];

        // return to_route('admin.print',['data' => $data]);
        return view('admin.cart_print',['data' => $data]);
    }

    public function print()
    {
        return view('admin.cart_print');
    }

    public function reportTicket()
    {
        $data = DB::table('orders') // Correct reference to 'orders'
        ->join('order_details', 'orders.code', '=', 'order_details.order_id') // Corrected to 'orders'
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->select('orders.*', 'order_details.*', 'products.*') // Ensure 'orders.*' is correct
        ->whereDate('orders.created_at', Carbon::today()) // Explicit table reference for created_at
        ->orderByDesc('orders.id') // Explicit table reference for id
        ->get();
        // dd($data[0]->code);

      

        return view('admin.report_ticket',['data' => $data]);
    }

    public function reportDelete(string $code)
    {
        $order = DB::table('orders')->where('code',$code)->delete();
        $order_detail = DB::table('order_details')->where('order_id',$code)->delete();

        return to_route('admin.report_ticket');
        
    }


}
