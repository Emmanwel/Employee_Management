<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Models\StudentGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentGroupController extends Controller
{
    //

    public function ViewStudentGroup()
    {
        $allData['allData'] = StudentGroup::all();
        return view('backend.setup.student_group.view_group', $allData);
    }
    //End 
    public function AddStudentGroup()
    {

        return view('backend.setup.student_group.add_group');
    }

    //End
    public function StoreStudentGroup(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|unique:student_groups,name',

            ],
        );
        $data = new StudentGroup();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Group Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.group.view')->with($notification);
    }

    //End Method

    public function EditStudentGroup($id)
    {
        $editData = StudentGroup::find($id);
        return view('backend.setup.student_group.edit_group', compact('editData'));
    }

    //End Method

    public function UpdateStudentGroup(Request $request, $id)
    {

        $data = StudentGroup::find($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:student_groups,name,' . $data->id

        ]);
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Group Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.group.view')->with($notification);
    }

    //End Method

    public function DeleteStudentGroup($id)
    {
        $student = StudentGroup::find($id);
        $student->delete();

        $notification = array(
            'message' => 'Student Group Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.year.view')->with($notification);
    }
}
