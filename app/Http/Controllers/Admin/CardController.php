<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Card::all();
        return view('admin.card_index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate(
            [
            'card' => 'required|unique:cards,card'
            ],
            [
                'card.required' => 'กรุณาใส่หมายเลข',
                'card.unique'   => 'หมายเลขนี้ถูกลงทะเบียนแล้ว',
            ]

        );
        session(['card' => $request->input('card')]);
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::forget('card'); // ลบ session('card')
        $request->validate(
            [
                'card'   => 'required',
                'status' => 'required',
                'code'   => 'required',
            ]
        );
        //บันทึกข้อมูล
        Card::create([
            'card' => $request->card,
            'status' => $request->status,
            'code' => $request->code,
        ]);
        return redirect()->back()->with('success','เพื่มข้อมูลบัตรสำเร็จ');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('admin.card_show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.card_edit');
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
       $card = Card::find($id);
       $card->delete();
       return to_route('admin.card_index');
    }
}
