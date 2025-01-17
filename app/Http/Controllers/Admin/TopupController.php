<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardRecord;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TopupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
        return view('admin.topup');
    }

    public function topup_show()
    {
        $data = Topup::all();
        return view('admin.topup_show',compact('data'));
    }

    public function check( Request $request)
    {
        $request->validate(
            [
                'card' => 'required',
            ]
        );

        $card = $request->card;

        $count = Card::where('card',$card)->count();

        if ($count != 1 ) {
            return redirect()->back()->with('error','หมายเลขไม่ได้ลงทะเบียน');
        }

        $data = Card::where('card',$card)->first(); // นำข้อมูลไปแสดง

        if ($data->status != 1 ) {

            return redirect()->back()->with('error','หมายเลขบัตรไม่สามารถใช้งานได้ ต้องยืนยัน สถานะ บัตร');

        } else {

            $countTopup = Topup::where('card',$card)->count();

            if ( $countTopup == 0 ) {

                session(['data' => $data]);
                return redirect()->back()->with('check','หมายเลขบัตรสามารถใช้งานได้');

            } else {

                $code = DB::table('topups')->where('card',$card)->get();

                if ($code[0]->status == 0) {

                    return redirect()->back();

                } else {

                    // ถ้าเจอข้อมูล ให้นำข้อมูลจากตาราง CardRecord ไปแสดง
                    $card_record = CardRecord::where('card',$card)->get();
                    session(['card_record' => $card_record]);
                    return redirect()->back()->with('status','หมายเลขเปิดใช้งานแล้ว');

                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'card'   => 'required',
                'price'  => 'required',
                'payment'  => 'required',
                'date_expiry'  => 'required',
            ]
        );

        // dd($request->input());

        // "_token" => "NAgG9FcHCKqasRjSTm3wpvxnGU8jOqMmqdiJ3MWS"
        // "card" => "0009714364"
        // "price" => "1000"
        // "discount" => "0"
        // "payment" => "cash"
        // "date_expiry" => "2024-10-20"
        // "comment" => "Lorem ipsum dolor sit amet consectetur adipisicing elit."
        // "method" => "topup"

        // ถ้าไม่มีส่วนลด
        if ($request->discount == 0) 
        {

            $total =  $request->price;

            // เก็บประวัตการเติมเงิน

            Topup::create(
                [
                    'card'          => $request->card,
                    'price'         => $request->price,
                    'discount'      => $request->discount,
                    'payment'       => $request->payment,
                    'date_expiry'   => $request->date_expiry,
                    'comment'       => $request->comment,
                    'total'         => $request->price,
                    'status'        => 1,
                    'method'        => $request->method,
                ]
            );

            // เก็บประวัติการใช้งานทุกอย่าง
            CardRecord::create(
                [
                    'card'          => $request->card,
                    'price'         => $request->price,
                    'discount'      => $request->discount,
                    'payment'       => $request->payment,
                    'date_expiry'   => $request->date_expiry,
                    'comment'       => $request->comment,
                    'total'         => $request->price,
                    'status'        => 1,
                    'method'        => $request->method,
                    'user'          => Auth::user()->name,
                ]
            );

        } 
        // ถ้ามีส่วนลด
        else 
        {

            $discount = $request->discount;
            $price = $request->price;
            $discount =  ($price * $discount) / 100 ;
            $total =  $price - $discount;

            Topup::create(
                [
                    'card'        => $request->card,
                    'price'       => $request->price,
                    'discount'    => $request->discount,
                    'payment'     => $request->payment,
                    'date_expiry' => $request->date_expiry,
                    'comment'     => $request->comment,
                    'status'      => 1,
                    'method'      => $request->method,
                    'total'       => $total,
                ]
            );

            CardRecord::create(
                [
                    'card' => $request->card,
                    'price' => $request->price,
                    'discount' => $request->discount,
                    'payment' => $request->payment,
                    'date_expiry' => $request->date_expiry,
                    'comment' => $request->comment,
                    'total' => $total,
                    'status' => 1,
                    'method' => $request->method,
                    'user' => Auth::user()->name,
                    'trainer' => '',
                ]
            );

        }

        return redirect()->back()->with('topup','เติมเงินสำเร็จ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        Session::forget('card_record');
        $data = DB::table('card_records')->get();
        return view('admin.topup_show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function topup_edit(string $card)
    {
        dd($card , session('card_record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
