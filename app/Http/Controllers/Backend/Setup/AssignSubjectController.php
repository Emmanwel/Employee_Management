<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Models\Subject;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\AssignSubject;
use App\Http\Controllers\Controller;

class AssignSubjectController extends Controller
{
    //
    public function ViewAssignSubject()
    {
        // $data['allData'] = AssignSubject::all();
        $data['allData'] = AssignSubject::select('class_id')->groupBy('class_id')->get();
        return view('backend.setup.assign_subject.view_assign_subject', $data);
    }

    //End

    public function AddAssignSubject()
    {
        $data['subjects'] = Subject::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.assign_subject.add_assign_subject', $data);
    }   
     //End 
    
    public function StoreAssignSubject(Request $request)
    {
        //Cannot delete the values in the subjects and store it
        $subjectCount = count($request->subject_id);
        if ($subjectCount != NULL) {
            for ($i = 0; $i < $subjectCount; $i++) {
                $assign_subject = new AssignSubject();
                $assign_subject->class_id = $request->class_id;
                $assign_subject->subject_id = $request->subject_id[$i];
                $assign_subject->full_mark = $request->full_mark[$i];
                $assign_subject->subjective_mark = $request->subjective_mark[$i];
                $assign_subject->pass_mark = $request->pass_mark[$i];
                $assign_subject->save();
            } // End For Loop
        } // End If Condition

        $notification = array(
            'message' => 'Subject Assigned Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('assign.subject.view')->with($notification);
    }  // End Method 

    public function EditAssignSubject($class_id)
    {
        $data['editData'] = AssignSubject::where('class_id', $class_id)->orderBy('subject_id', 'asc')->get();
        // dd($data['editData']->toArray());
        $data['subjects'] = Subject::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.assign_subject.edit_assign_subject', $data);
    }
    //End Edit Method

    public function UpdateAssignSubject(Request $request, $class_id)
    {
        if ($request->subject_id == NULL) {

            $notification = array(
                'message' => 'You have not Selected any of the Subjects',
                'alert-type' => 'error'
            );

            return redirect()->route('assign.subject.edit', $class_id)->with($notification);
        } else {

            $subjectCount = count($request->subject_id);
            AssignSubject::where('class_id', $class_id)->delete();
            for ($i = 0; $i < $subjectCount; $i++) {
                $assign_subject = new AssignSubject();
                $assign_subject->class_id = $request->class_id;
                $assign_subject->subject_id = $request->subject_id[$i];
                $assign_subject->full_mark = $request->full_mark[$i];
                $assign_subject->subjective_mark = $request->subjective_mark[$i];
                $assign_subject->pass_mark = $request->pass_mark[$i];
                $assign_subject->save();
            } // End For Loop	 

        } // end Else

        $notification = array(
            'message' => 'Subjects Marks Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('assign.subject.view')->with($notification);
    } // end Method 

    public function DetailsAssignSubject($class_id)
    {
        $data['detailsData'] = AssignSubject::where('class_id', $class_id)->orderBy('subject_id', 'asc')->get();

        return view('backend.setup.assign_subject.details_assign_subject', $data);
    }
}