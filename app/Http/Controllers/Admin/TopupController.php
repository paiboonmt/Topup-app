<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Topup;
use Illuminate\Http\Request;
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

        $count = Card::where('card',$card)->count(); // นับจำนวนแถวในตาราง cards

        if ($count != 1) {
            return redirect()->back()->with('error','หมายเลขไม่ได้ลงทะเบียน');
        }

        $data = Card::where('card',$card)->first(); // นำข้อมูลไปแสดง

        if ($data->status != 1 ) {

            return redirect()->back()->with('error','หมายเลขบัตรไม่สามารถใช้งานได้ ต้องยืนยัน สถานะ บัตร');

        } else {
            $countTopup = Topup::where('card',$card)->count();
            if ($countTopup == 0) {
                session(['data' => $data]);
                return redirect()->back()->with('check','หมายเลขบัตรสามารถใช้งานได้');
            } else {
                // topup table
                $code = DB::table('topups')->where('card',$card)->get();
                // 0 ยังไม่เปิดใช้งาน // 1 เปิดใช้งานแล้ว
                if ($code[0]->status == 0) {
                    session(['data' => $data]);
                    return redirect()->back()->with('check','หมายเลขบัตรสามารถใช้งานได้');
                } else {
                    // Session::forget('code');
                    session(['code'=>$code]);
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

        if ($request->discount == 0) {

            $total =  $request->price;

            Topup::create(
                [
                    'card' => $request->card,
                    'price' => $request->price,
                    'discount' => $request->discount,
                    'payment' => $request->payment,
                    'date_expiry' => $request->date_expiry,
                    'comment' => $request->comment,
                    'total' => $total,
                ]
            );

        } else {

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
                    'total'       => $total,
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

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
