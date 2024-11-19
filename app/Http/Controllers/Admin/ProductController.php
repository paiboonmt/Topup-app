<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();
        return view('admin.product_index',[
            'products' => $data
        ]);
    }

    public function store( Request $request)
    {
        $request->validate(
            [
                'name'   => 'required|max:100',
                'price'  => 'required',
            ]
        );

        $product = Product::create(
            [
                'name'      => $request->name,
                'price'     => $request->price,
                'quantity'  => 1 ,
                'user'      => Auth::user()->name
            ]
        );


        return redirect()->back()->with('create','เพื่มสินค้าเรียบร้อยแล้ว.');

    }

    public function edit(Request $request)
    {
        dd($request->input());
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return to_route('admin.product_index');
    }
}
