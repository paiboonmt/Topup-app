<?php

namespace App\Http\Controllers\Md;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MdController extends Controller
{
    public function index()
    {
        return view('md.dashboard');
    }

    public function report_daily()
    {
        return view('md.report_daily');
    }

    public function report_ticket()
    {
        return view('md.report_ticket');
    }

    public function report_summary()
    {
        return view('md.report_summary');
    }

    public function report_checkin()
    {
        return view('md.report_checkin');
    }
}
