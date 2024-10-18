<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Topup;
use Illuminate\Http\Request;

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
        return view('admin.topup_show');
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
        }

        session([ 'data' => $data ]);
        return redirect()->back()->with('check','หมายเลขบัตรสามารถใช้งานได้');

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
                'discount'  => 'required',
                'payment'  => 'required',
                'date_expiry'  => 'required',
                'comment'  => 'required',
            ]
        );

        Topup::create(
            [
                'card' => $request->card,
            ]
        );

        return redirect()->back();

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
