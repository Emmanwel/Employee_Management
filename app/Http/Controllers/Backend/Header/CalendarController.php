<?php

namespace App\Http\Controllers\Backend\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    //
    public function CalenderView()
    {
        return view('backend.calender.calender_view');
    } //END
}
