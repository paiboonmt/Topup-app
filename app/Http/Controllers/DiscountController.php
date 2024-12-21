<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = DB::table('discounts')->get();
        return view('admin.discount',compact('discounts'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'discount_type' => 'required',
            'discount_value' => 'required',
        ]);

        DB::table('discounts')->insert([
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
        ]);

        return redirect()->back()->with('success','Discount created successfully');
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'discount_type' => 'required',
            'discount_value' => 'required',
        ]);

        DB::table('discounts')->where('id',$request->id)->update([
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
        ]);

        return redirect()->back()->with('success','Discount updated successfully');
    }

    public function delete($id)
    {
        DB::table('discounts')->where('id',$id)->delete();
        return redirect()->back()->with('success','Discount deleted successfully');
    }
}
