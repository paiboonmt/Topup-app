<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class ScanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('trainer.scan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function check(Request $request)
    {
        $request->validate(
            [
                'code' => 'required',
            ]
        );

        $check_code = Card::where('card',$request->input('code'))->count();

        if ( $check_code != 1 ) {
            // ถ้าไม่เจอหมายเลข ให้กลับไป
            // dd($check_code);
            session(['old_card' => $request->input('code')]);
            return redirect()->back()->with('error','ไม่พบหมายเลขในระบบ');

        } else {
            // ถ้าเจอหมายเลขให้ทำงานต่อ
            // dd($check_code);
            // ตรวจสอบข้อมูล
            $data = Topup::where('card',$request->input('code'))->first();

            // dd($data->card);
            if ( $data->date_expiry < date('Y-m-d') ) {

                session(['card' => $data->card , 'expiry' => $data->date_expiry]);
                return redirect()->back()->with('date_expiry','บัตรหมดอายุการใช้งาน กรุณาติดต่อฝ่ายบริการ');

            } else {

                // ตรวจสอบจำนวนเงิน

            }



        }


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
