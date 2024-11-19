<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardRecord;
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
            session(['old_card' => $request->input('code')]);
            return redirect()->back()->with('error','ไม่พบหมายเลขในระบบ');
        } else {
          
            $data = Topup::where('card',$request->input('code'))->first();

            // dd($data);

            if ( $data->date_expiry < date('Y-m-d') ) {

                session(['card' => $data->card , 'expiry' => $data->date_expiry]);
                session(['data' => $data ]);
                return redirect()->back()->with('date_expiry','บัตรหมดอายุการใช้งาน กรุณาติดต่อฝ่ายบริการ');

            } else {

                // ตรวจสอบจำนวนเงิน
                if ( $data->total <= 0 ) {

                    session(['card' => $data->card ]);
                    return redirect()->back()->with('lowPrice','จำนวนเงินเหลือน้อย');

                } else {
                    session(['data' => $data ]);
                    return redirect()->back();

                    // ส่งไปหน้า ฟอร์มข้อมูล
                    // "id" => 1
                    // "card" => "0009714364"
                    // "price" => "1000.00"
                    // "discount" => 0
                    // "payment" => "cash"
                    // "date_expiry" => "2024-11-20"
                    // "comment" => "Lorem ipsum dolor sit amet consectetur adipisicing elit."
                    // "total" => "1000.00"
                    // "status" => 1
                    // "method" => "topup"
                    // "created_at" => "2024-11-13 10:31:16"
                    // "updated_at" => "2024-11-13 10:31:16"
                    // $setData = CardRecord::create(
                    //     [
                    //         'card' => $data->card,
                    //         'price' => $data->price,
                    //         'discount' => $data->discount,
                    //         'payment' => 'Trainer',
                    //         'date_expiry' => $data->date_expiry,
                    //         'comment' => "Trainer add code",
                    //     ]
                    // );


                }

            }



        }


    }

    public function removeSession()
    {
        // dd(Session::all());
        Session::forget(['old_card','card','expiry','data']);
        return redirect()->back();
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
