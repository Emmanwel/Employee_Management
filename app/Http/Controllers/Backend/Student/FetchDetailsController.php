<?php

namespace App\Http\Controllers\Backend\Student;

use App\Models\User;
use App\Models\StudentMarks;
use Illuminate\Http\Request;
use App\Models\RegisterStudent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FetchDetailsController extends Controller
{
    //
    public function fees()
    {
       
        $students = Auth::user();

        $fees = StudentMarks::where('student_id', $students->id)->orderBy('id', 'desc')->get();

        // dd($marks, $students);

        return view('backend.details.fees_view', compact('marks', 'students'));
    } // end 
}