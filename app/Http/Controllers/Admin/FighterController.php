<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FighterController extends Controller
{
  
    public function index()
    {   
        $data = DB::table('member')
            ->where('status_code',3)
            ->orderByDesc('id')
            ->get();
        return view('admin.fighters',compact('data'));
    }

    public function show(string $id)
    {
        return view('admin.fighter_profile');
    }

}
