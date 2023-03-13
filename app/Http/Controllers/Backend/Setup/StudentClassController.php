<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentClassController extends Controller
{
    //
    public function ViewStudent()
    {
        $data['allData'] = StudentClass::all();
        return view('backend.setup.student_class.view_class', $data);
    }

    //End method

    public function AddStudentClass()
    {

        return view('backend.setup.student_class.add_class');
    }
    public function StoreStudentClass(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|unique:student_classes,name',

            ],
        );
        $data = new StudentClass();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Class Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.class.view')->with($notification);
    }

    //End Method

    public function EditStudentClass($id)
    {
        $editData = StudentClass::find($id);
        return view('backend.setup.student_class.edit_class', compact('editData'));
    }

    //End Method

    public function UpdateStudentClass(Request $request, $id)
    {

        $data = StudentClass::find($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:student_classes,name,' . $data->id

        ]);
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Class Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.class.view')->with($notification);
    }

    //End Method

    public function DeleteStudentClass($id)
    {
        $student = StudentClass::find($id);
        $student->delete();

        $notification = array(
            'message' => 'Student Class Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.class.view')->with($notification);
    }
}
