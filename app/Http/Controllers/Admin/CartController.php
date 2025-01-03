<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
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
            $setNum_bill = intval($setNum_bill);
        } else {
            $string = DB::table('orders')
                ->whereDate('created_at', Carbon::today())
                ->orderByDesc('id')
                ->first();
            $num_bill = intval($string->num_bill);
            $setNum_bill = $num_bill + 1 ;
        }
        // -------------------------------------
        $codeNumber = round(microtime(true));
        // -------------------------------------

        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        // -------------------------------------
        $payments = Payment::all();
        // -------------------------------------

        $discounts = Discount::all();

        return view('admin.cart_index',
            [
                'products'      => $products,
                'setNum_bill'   => $setNum_bill,
                'cart'          => $cart,
                'total'         => $total,
                'codeNumber'    => $codeNumber,
                'payments'      => $payments,
                'discounts'     => $discounts
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

    public function checkOut( Request $request )
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
        // $discount       = $request->discount;
        $payment        = $request->payment;
        $staDate        = $request->staDate;
        $expDate        = $request->expDate;
        $customerName   = $request->customerName;
        $comment        = $request->comment;

        session(['total' => $total]);
        session(['num_bill' => $num_bill]);
        session(['code' => $code]);
        // session(['discount' => $discount]);
        session(['payment' => $payment]);
        session(['staDate' => $staDate]);
        session(['expDate' => $expDate]);
        session(['customerName' => $customerName]);
        session(['comment' => $comment]);

        $selectOption = explode('|',$request->input('payment'));
        $payment_name = $selectOption[0];
        $payment_value = $selectOption[1];

        $selectOptionDiscount = explode('|',$request->input('discount'));
        $discount_name = $selectOptionDiscount[0];
        $discount_value = $selectOptionDiscount[1];


        // dump($request->all(),$selectOptionDiscount,$discount_name,$discount_value , $payment_value );


        // มีส่วนลด และ ภาษี และ ราคาสุทธิ และ ราคาสุทธิที่ต้องจ่าย และ บันทึกข้อมูล ลงฐานข้อมูล 
        if ( $discount_value != 0) {

            $netDiscount = ( $total * $discount_value ) / 100 ; // 
            $netTotal = $total - $netDiscount;
            $total = $total - $netDiscount;

            // dd($netDiscount,$netTotal,$total);
            
            if ( $payment_value == 7 ) {
                $net = 7;
                $vat = ( $total * 7 ) / 100 ;
            } elseif ( $payment_value == 3 ) {
                $net = 3;
                $vat = ( $total * 3 ) / 100 ;
            } elseif ( $payment_value == 0 ) {
                $net = 1;
                $vat = 0;
            }

            $order = new Order;
            $order->code            = $code;
            $order->num_bill        = $num_bill;
            $order->fname           = $customerName;
            $order->discount        = $discount_value;
            $order->net_discount    = $netDiscount;
            $order->sub_discount    = $netTotal;
           
            if ( $net == 7) {
                $order->vat7        = $net;
                $order->vat3        = 0 ;
                $total              = $total+$vat;
            } elseif ( $net == 3 ) {
                $order->vat7        = 0;
                $order->vat3        = $net;
                $total              = $total+$vat;
            } else {
                $order->vat7        = 0;
                $order->vat3        = 0;
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

        // ไม่มีส่วนลด และ ภาษี และ ราคาสุทธิ และ ราคาสุทธิที่ต้องจ่าย และ บันทึกข้อมูล ลงฐานข้อมูล
        if ( $discount_value == 0) {

            if ( $payment_value == 7 ) {
                $net = 7;
                $vat = ( $total * 7 ) / 100 ;
            } elseif ( $payment_value == 3 ) {
                $net = 3;
                $vat = ( $total * 3 ) / 100 ;
            } elseif ( $payment_value == 0 ) {
                $net = 1;
                $vat = 0;
            }

            $netDiscount = 0;
            $netTotal = 0;

            // บันทึกข้อมูล
            $order = new Order;
            $order->code        = $code;
            $order->num_bill    = $num_bill;
            $order->fname       = $customerName;
            $order->discount    = $discount_value;
            $order->net_discount = 0;
            $order->sub_discount = 0;
           
            if ( $net == 7)  {
                $order->vat7        = $net;
                $order->vat3        = 0 ;
                $total              = $total+$vat;
            } elseif ( $net == 3 ) 
            {
                $order->vat7        = 0;
                $order->vat3        = $net;
                $total              = $total+$vat;
            } else {
                $order->vat7        = 0;
                $order->vat3        = 0;
                $total              = $total+$vat;
            }
            
            $order->net         = $vat;
            $order->total       = $total;
            $order->payment     = $payment_name;
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

        $data = [
            'total'          => $total,
            'num_bill'       => $request->num_bill,
            'code'           => $request->code,
            'discount'       => $discount_value,
            'netDiscount'    => $netDiscount,
            'netTotal'       => $netTotal,
            'payment'        => $payment_name,
            'staDate'        => $request->staDate,
            'expDate'        => $request->expDate,
            'customerName'   => $request->customerName,
            'comment'        => $request->comment,
            'net'            => $net,
            'vat'            => $vat,
        ];

        return view('admin.cart_print',['data' => $data]);
    }

    public function print()
    {
        return view('admin.cart_print');
    }

    public function viewBill( string $code ){
        
        $data = DB::table('orders')
            ->join('order_details' , 'orders.code' , '=' , 'order_details.order_id' )
            ->join('products' ,'order_details.product_id' , '=' , 'products.id')
            ->select('orders.*', 'orders.total AS ototal' ,'order_details.*', 'order_details.quantity as qty' , 'products.*')
            ->where('orders.code',$code)
            ->get();
            return view('admin.view_bill',['data' => $data]);

    }

}
