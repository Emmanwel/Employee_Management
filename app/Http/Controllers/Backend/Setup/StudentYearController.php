<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Models\StudentYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentYearController extends Controller
{
    //
    public function ViewStudentYear()
    {
        $allData['allData'] = StudentYear::all();
        return view('backend.setup.student_year.view_year', $allData);
    }

    //End 
    public function AddStudentYear()
    {
        return view('backend.setup.student_year.add_year');
    }

    //End
    public function StoreStudentYear(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|unique:student_years,name',

            ],
        );
        $data = new StudentYear();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Year Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.year.view')->with($notification);
    }

    //End Method

    public function EditStudentYear($id)
    {
        $editData = StudentYear::find($id);
        return view('backend.setup.student_year.edit_year', compact('editData'));
    }

    //End Method

    public function UpdateStudentYear(Request $request, $id)
    {

        $data = StudentYear::find($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:student_years,name,' . $data->id

        ]);
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Year Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.year.view')->with($notification);
    }

    //End Method

    public function DeleteStudentYear($id)
    {
        $student = StudentYear::find($id);
        $student->delete();

        $notification = array(
            'message' => 'Student Year Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.year.view')->with($notification);
    }
}
