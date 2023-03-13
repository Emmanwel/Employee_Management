<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function ViewSubject()
    {
        $data['allData'] = Subject::all();
        return view('backend.setup.school_subject.view_school_subject', $data);
    }


    public function AddSubject()
    {
        return view('backend.setup.school_subject.add_school_subject');
    }

    public function StoreSubject(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|unique:subjects,name',

        ]);

        $data = new Subject();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Subject Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('school.subject.view')->with($notification);
    }


    public function EditSubject($id)
    {
        $editData = Subject::find($id);
        return view('backend.setup.school_subject.edit_school_subject', compact('editData'));
    }



    public function UpdateSubject(Request $request, $id)
    {

        $data = Subject::find($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:subjects,name,' . $data->id

        ]);


        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Subject Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('school.subject.view')->with($notification);
    }


    public function DeleteSubject($id)
    {
        $user = Subject::find($id);
        $user->delete();

        $notification = array(
            'message' => 'Subject Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('school.subject.view')->with($notification);
    }
}
