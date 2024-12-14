<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index() {
        $data = Payment::all();
        return view('admin.payment.payment',compact('data'));
    }

    public function create( Request $request ) {
        $payment = new Payment;
        $payment->name = $request->name;
        $payment->value = $request->value;
        $payment->save();
        return to_route('admin.payment');
    }

    public function update( Request $request ) {
        $payment = Payment::find($request->id);
        $payment->name = $request->name;
        $payment->value = $request->value;
        $payment->save();
        return to_route('admin.payment');
    }

    public function destroy( string $id ) {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return to_route('admin.payment');
    }
}
