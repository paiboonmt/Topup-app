<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $day = date('Y-m-d');
        $data = DB::table('member as m')
            ->join('products as p', 'm.package', '=', 'p.id')
            ->select('m.*', 'p.*', 'm.id as mid')
            ->where(function ($query) {
                $query->where('status_code', 4)
                      ->orWhere('status_code', 2);
            })
            // ->where('status_code',4)
            ->where('exp_date', '>=', $day )
            ->orderBy('m.id', 'desc')
            // ->limit(10)
            ->get();
        return view('admin.customer',compact('data'));
    }

    public function expired()
    {
        $day = date('Y-m-d');
        $data = DB::table('member as m')
            ->join('products as p', 'm.package', '=', 'p.id')
            ->select('m.*', 'p.*', 'm.id as mid')
            ->where(function ($query) {
                $query->where('status_code', 4)
                      ->orWhere('status_code', 2);
            })
            // ->where('status_code',4)
            ->where('exp_date', '<', $day )
            ->orderBy('m.id', 'desc')
            // ->limit(10)
            ->get();
        return view('admin.customer_expired',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer_create');
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
