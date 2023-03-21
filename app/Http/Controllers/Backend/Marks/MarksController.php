<?php

namespace App\Http\Controllers\Backend\Marks;

use App\Models\ExamType;
use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentMarks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarksController extends Controller
{
    //
        public function MarksAdd()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['exam_types'] = ExamType::all();

        return view('backend.marks.marks_add', $data);
    } ///END
    public function MarksStore(Request $request)
    {

        $studentcount = $request->student_id;
        if ($studentcount) {
            for ($i = 0; $i < count($request->student_id); $i++) {
                $data = new StudentMarks();
                $data->year_id = $request->year_id;
                $data->class_id = $request->class_id;
                $data->assign_subject_id = $request->assign_subject_id;
                $data->exam_type_id = $request->exam_type_id;
                $data->student_id = $request->student_id[$i];
                $data->id_no = $request->id_no[$i];
                $data->marks = $request->marks[$i];
                $data->save();
            } // end for loop
        } // end if condition

        $notification = array(
            'message' => 'Student Marks Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method

    public function MarksEdit()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['exam_types'] = ExamType::all();

        return view('backend.marks.marks_edit', $data);
    } //END

    public function MarksEditGetStudents(Request $request)
    {
        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $assign_subject_id = $request->assign_subject_id;
        $exam_type_id = $request->exam_type_id;

        $getStudent = StudentMarks::with(['student'])->where('year_id', $year_id)->where('class_id', $class_id)->where('assign_subject_id', $assign_subject_id)->where('exam_type_id', $exam_type_id)->get();

        return response()->json($getStudent);
    } //END
    public function MarksUpdate(Request $request)
    {

        StudentMarks::where('year_id', $request->year_id)->where('class_id', $request->class_id)->where('assign_subject_id', $request->assign_subject_id)->where('exam_type_id', $request->exam_type_id)->delete();

        $studentcount = $request->student_id;
        if ($studentcount) {
            for ($i = 0; $i < count($request->student_id); $i++) {
                $data = new StudentMarks();
                $data->year_id = $request->year_id;
                $data->class_id = $request->class_id;
                $data->assign_subject_id = $request->assign_subject_id;
                $data->exam_type_id = $request->exam_type_id;
                $data->student_id = $request->student_id[$i];
                $data->id_no = $request->id_no[$i];
                $data->marks = $request->marks[$i];
                $data->save();
            } // end for loop
        } // end if conditon

        $notification = array(
            'message' => 'Student Marks Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End marks

}