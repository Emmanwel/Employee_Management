<?php

namespace App\Http\Controllers\Backend\Student;



//use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;

//use niklasravnsborg\DomPDF\Facade as PDF;
//use niklasravnsborg\LaravelPdf\Facade as PDF;

//use niklasravnsborg\LaravelPdf\PDF;
//use \PDF;

use App\Models\User;
use Barryvdh\DomPDF\PDF;
use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use Illuminate\Http\Request;
use App\Models\DiscountStudent;
use App\Models\RegisterStudent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;

class StudentRegController extends Controller
{
    //

    public function StudentRegView()
    {
        //$data['allData'] = RegisterStudent::all();
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['users'] = User::all();

        //Display Years & Classes in the search
        // $data['year_id'] = StudentYear::all();
        // /$data['class_id'] = StudentClass::all();

        $data['year_id'] = StudentYear::orderBy('id', 'asc')->first()->id;
        $data['class_id'] = StudentClass::orderBy('id', 'asc')->first()->id;

        //dd($data['class_id']);
        //$data['allData'] = RegisterStudent::all();
        $data['allData'] = RegisterStudent::where('year_id', $data['year_id'])
            ->where('class_id', $data['class_id'])
            ->get();
        return view('backend.students.student_reg.student_view', $data);
    }
    //End

    public function StudentClassYearSearch(Request $request)
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();

        $data['year_id'] = $request->year_id;
        $data['class_id'] = $request->class_id;

        $data['allData'] = RegisterStudent::where('year_id', $request->year_id)
            ->where('class_id', $request->class_id)
            ->get();
        return view('backend.students.student_reg.student_view', $data);
    }
    public function StudentRegAdd()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['groups'] = StudentGroup::all();
        $data['shifts'] = StudentShift::all();
        return view('backend.students.student_reg.student_add', $data);
    }
    ///End Method

    public function StudentRegStore(Request $request)
    {
        DB::transaction(function () use ($request) {
            $checkYear = StudentYear::find($request->year_id)->name;
            $student = User::where('userType', 'Student')
                ->orderBy('id', 'DESC')
                ->first();

            if ($student == null) {
                $firstReg = 0;
                $studentId = $firstReg + 1;
                if ($studentId < 10) {
                    $id_no = '000' . $studentId;
                } elseif ($studentId < 100) {
                    $id_no = '00' . $studentId;
                } elseif ($studentId < 1000) {
                    $id_no = '0' . $studentId;
                }
            } else {
                $student = User::where('userType', 'Student')
                    ->orderBy('id', 'DESC')
                    ->first()->id;
                $studentId = $student + 1;
                if ($studentId < 10) {
                    $id_no = '000' . $studentId;
                } elseif ($studentId < 100) {
                    $id_no = '00' . $studentId;
                } elseif ($studentId < 1000) {
                    $id_no = '0' . $studentId;
                }
            } // end else



            $final_id_no = $checkYear . $id_no;
            $user = new User();
            $code = rand(0000, 9999);
            $user->id_no = $final_id_no;
            $user->password = bcrypt($code);
            $user->userType = 'Student';
            $user->code = $code;
            $user->name = $request->name;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->nokmobile = $request->nokmobile;
            $user->dob = date('Y-m-d', strtotime($request->dob));


            //$user = \Carbon\Carbon::parse($request->nokmobile)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days');

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/student_images'), $filename);
                $user['image'] = $filename;
            }
            $user->save();

            $register_student = new RegisterStudent();
            $register_student->student_id = $user->id;
            $register_student->year_id = $request->year_id;
            $register_student->class_id = $request->class_id;
            $register_student->group_id = $request->group_id;
            $register_student->shift_id = $request->shift_id;
            $register_student->save();

            event(new Registered($user));


            $discount_student = new DiscountStudent();
            $discount_student->register_student_id = $register_student->id;
            $discount_student->fee_category_id = '1';
            $discount_student->discount = $request->discount;
            $discount_student->save();
        });



        $notification = [
            'message' => 'Student Registered Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('student.registration.view')
            ->with($notification);
    } // End Method

    public function EditStudentDetails($student_id)
    {
        // $data['discounts'] = DiscountStudent::all();
        // $data['users'] = User::all();
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['groups'] = StudentGroup::all();
        $data['shifts'] = StudentShift::all();
        //$data['editData'] = RegisterStudent::where('student_id', $student_id)->orderBy('subject_id', 'asc')->get();

        //From the model that links discounts and students with register students table model
        $data['editData'] = RegisterStudent::with(['student', 'discount'])
            ->where('student_id', $student_id)
            ->first();

        //dd($data['editData']->toArray());
        return view('backend.students.student_reg.student_edit', $data);
    }
    //End

    public function UpdateStudentDetails(Request $request, $student_id)
    {
        DB::transaction(function () use ($request, $student_id) {
            $user = User::where('id', $student_id)->first();
            $user->name = $request->name;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->nokmobile = $request->nokmobile;
            $user->dob = date('Y-m-d H:i"', strtotime($request->dob));

            if ($request->file('image')) {
                $file = $request->file('image');
                @unlink(public_path('upload/student_images/' . $user->image));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/student_images'), $filename);
                $user['image'] = $filename;
            }
            $user->save();

            $register_student = RegisterStudent::where('id', $request->id)
                ->where('student_id', $student_id)
                ->first();

            $register_student->year_id = $request->year_id;
            $register_student->class_id = $request->class_id;
            $register_student->group_id = $request->group_id;
            $register_student->shift_id = $request->shift_id;
            $register_student->save();

            $discount_student = DiscountStudent::where('register_student_id', $request->id)->first();

            $discount_student->discount = $request->discount;
            $discount_student->save();
        });

        $notification = [
            'message' => 'Student Details Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('student.registration.view')
            ->with($notification);
    } //end

    public function PromoteStudent($student_id)
    {
        // $data['discounts'] = DiscountStudent::all();
        // $data['users'] = User::all();
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['groups'] = StudentGroup::all();
        $data['shifts'] = StudentShift::all();
        //$data['editData'] = RegisterStudent::where('student_id', $student_id)->orderBy('subject_id', 'asc')->get();

        //From the model that links discounts and students with register students table model
        $data['editData'] = RegisterStudent::with(['student', 'discount'])
            ->where('student_id', $student_id)
            ->first();

        //dd($data['editData']->toArray());
        return view('backend.students.student_reg.student_edit', $data);
    }
    //End

    public function UpdateStudentPromotion(Request $request, $student_id)
    {
        DB::transaction(function () use ($request, $student_id) {
            $user = User::where('id', $student_id)->first();
            $user->name = $request->name;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->dob = date('Y-m-d', strtotime($request->dob));

            if ($request->file('image')) {
                $file = $request->file('image');
                @unlink(public_path('upload/student_images/' . $user->image));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/student_images'), $filename);
                $user['image'] = $filename;
            }
            $user->save();

            $register_student = new RegisterStudent();
            $register_student->student_id = $request->student_id;
            $register_student->year_id = $request->year_id;
            $register_student->class_id = $request->class_id;
            $register_student->group_id = $request->group_id;
            $register_student->shift_id = $request->shift_id;
            $register_student->save();

            $discount_student = new DiscountStudent();

            $discount_student->assign_student_id = $register_student->id;
            $discount_student->fee_category_id = '1';
            $discount_student->discount = $request->discount;
            $discount_student->save();
        });

        $notification = [
            'message' => 'Student Promoted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('student.registration.view')
            ->with($notification);
    } //end
    public function GenerateStudentDetailsPDF($student_id)
    {

        // Fetch user details from multiple tables
        // $data['years'] = StudentYear::all();
        // $data['classes'] = StudentClass::all();
        // $data['groups'] = StudentGroup::all();
        // $data['shifts'] = StudentShift::all();
        // $data['discounts'] = DiscountStudent::all();
        // $data['allDetails'] = RegisterStudent::all();
        $data['details'] = RegisterStudent::with(['student', 'discount'])->where('student_id', $student_id)->first();

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('backend.students.student_reg.student_details_pdf', $data);

        //$pdf = PDF::loadView('backend.students.student_reg.student_details_pdf', $data);
        //$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
}