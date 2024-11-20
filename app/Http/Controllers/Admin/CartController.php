<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $products = Product::all();

        // $order = Order::where('date','like','%'.Carbon::today().'%');

        $order = DB::table('orders')
            ->select('num_bill')
            ->whereDate('created_at' , 'LIKE' , '%'.Carbon::today().'%')->get();

        if ( $order)

        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        return view('admin.cart_index',
            [
                'products'  => $products,
                'order'     => $order,
                'cart'      => $cart,
                'total'     => $total
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

    public function removeItem(Request $request) {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            if ( $quantity == 2 ) {
                $cart[$productId]['quantity'] --  ;
            } elseif ( $quantity == 1 ){
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] -- ;
            }
            session()->put('cart', $cart);
        }
        return to_route('admin.cart_index');
    }

    public function cancelCart()
    {
        // dd(Session::all());
        Session::forget('cart');
        return redirect()->back();
    }
}
