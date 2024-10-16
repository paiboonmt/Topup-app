<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use tidy;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Trainer::all();
        return view('admin.trainer',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trainer_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'code' => 'required|unique:trainers,code',
                'name' => 'required|unique:trainers,name',
                'phone' => 'required|unique:trainers,phone',
            ],
            [
                'code.required' => 'โปรดป้อนหมายเลข',
                'code.unique' => 'มีหมายเลขนี้อยู่ในระบบแล้ว',
                'name.required' => 'โปรดป้อนชื่อของท่าน',
                'name.unique' => 'มีชื่อนี้อยู่ในระบบแล้ว',
                'phone.required' => 'โปรดป้อนหมายเลขโทรศัพท์ของท่าน',
                'phone.unique' => 'มีเบอร์โทรหมายเลขนี้อยู่ในระบบแล้ว',
            ]
        );
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newImageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/trainer/'),$newImageName);
            Trainer::create([
                'code' => $request->code,
                'name' => $request->name,
                'phone' => $request->phone,
                'status' => 1,
                'image' => $newImageName
            ]);
            return to_route('admin.trainer_index')->with('success','Create data success fully.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Trainer::findOrFail($id);
        return view('admin.trainer_show',compact('data'));
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

        $trainer = Trainer::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($trainer->image){
                $oldImagePath = public_path('images/trainer/'.$trainer->image);
                if (file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('image');
            $newImageName = time().'.'. $image->getClientOriginalExtension();
            $image->move(public_path('images/trainer/'),$newImageName);
            $trainer->code = $request->code;
            $trainer->name = $request->name;
            $trainer->phone = $request->phone;
            $trainer->status = 1;
            $trainer->image = $newImageName;
            $trainer->save();
        }

        return redirect()->back()->with('update','Update data success fully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trainer = Trainer::findOrFail($id);
        if ($trainer->image){
            $oldImagePath = public_path('images/trainer/'.$trainer->image);
            if (file_exists($oldImagePath)){
                unlink($oldImagePath);
            }
        }
        $trainer->delete();
        return to_route('admin.trainer_index');

    }
}
