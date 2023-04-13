<?php

namespace App\Http\Controllers\Frontend\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontHomePageController extends Controller
{
    //
    public function index()
    {
        return view('frontend.dashboard.home_dashboard');
    } //
    public function dashboard()
    {
        $user = auth()->user();
        $courses = $user->courses;
        return view('frontend.dashboard.marks_view', ['courses' => $courses]);
    }
}
