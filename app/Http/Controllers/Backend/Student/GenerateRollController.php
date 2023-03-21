<?php

namespace App\Http\Controllers\Backend\student;

use App\Models\StudentYear;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\RegisterStudent;
use App\Http\Controllers\Controller;

class GenerateRollController extends Controller
{
    //
    public function GenerateRollView()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        return view('backend.students.roll_generate.roll_generate_view', $data);
    } //End
    public function GetStudents(Request $request)
    {
        //dd('view an array of data');
        $allData = RegisterStudent::with(['student'])->where('year_id', $request->year_id)->where('class_id', $request->class_id)->get();
        // dd($allData->toArray());
        return response()->json($allData);
    }


    public function StudentRollStore(Request $request)
    {

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        if ($request->student_id != null) {
            for ($i = 0; $i < count($request->student_id); $i++) {
                RegisterStudent::where('year_id', $year_id)->where('class_id', $class_id)->where('student_id', $request->student_id[$i])->update(['roll' => $request->roll[$i]]);
            } // end for loop
        } else {
            $notification = array(
                'message' => 'Sorry there are no student',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        } // End IF Condition

        $notification = array(
            'message' => 'Well Done Roll Generated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('view.generated.roll')->with($notification);
    } // end Method 


}