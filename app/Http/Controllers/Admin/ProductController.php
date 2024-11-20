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

        Product::create(
            [
                'name'      => $request->name,
                'price'     => $request->price,
                'quantity'  => 1 ,
                'user'      => Auth::user()->name
            ]
        );


        return redirect()->back()->with('product_create','เพื่มสินค้าเรียบร้อยแล้ว.');

    }

    public function update(Request $request)
    {
       
        $request->validate(
            [
                'id'    => 'required',
                'name'  => 'required',
                'price' => 'required'
            ]
        );

        Product::where('id', $request->id)
            ->update(
                    [
                        'name' => $request->name , 
                        'price' => $request->price,
                        'quantity'  => 1 ,
                        'user'      => Auth::user()->name
                    ]
                );
        return redirect()->back()->with('product_update','แก้ไขสินค้าเรียบร้อย');

    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return to_route('admin.product_index');
    }
}
