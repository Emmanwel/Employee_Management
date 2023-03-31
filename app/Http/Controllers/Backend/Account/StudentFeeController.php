<?php

namespace App\Http\Controllers\Backend\Account;

use App\Models\FeeCategory;
use App\Models\StudentYear;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\RegisterStudent;
use App\Models\FeeCategoryAmount;
use App\Models\AccountsStudentsFee;
use App\Http\Controllers\Controller;

class StudentFeeController extends Controller
{
    //

    public function ViewStudentFee()
    {

        $data['allData'] = AccountsStudentsFee::all();
        return view('backend.accounts.student_fee.student_fee_view', $data);
    } //End

    public function AddStudentFee()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['fee_categories'] = FeeCategory::all();
        return view('backend.accounts.student_fee.student_fee_add', $data);
    } //End

    public function StudentFeeGetStudent(Request $request)
    {

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $fee_category_id = $request->fee_category_id;
        $date = date('Y-m', strtotime($request->date));

        $data = RegisterStudent::with(['discount'])->where('year_id', $year_id)->where('class_id', $class_id)->get();

        $html['thsource']  = '<th>ID No</th>';
        $html['thsource'] .= '<th>Student Name</th>';
        $html['thsource'] .= '<th>Father Name</th>';
        $html['thsource'] .= '<th>Original Fee </th>';
        $html['thsource'] .= '<th>Discount Amount</th>';
        $html['thsource'] .= '<th>Fee (This Student)</th>';
        $html['thsource'] .= '<th>Select</th>';

        foreach ($data as $key => $std) {
            $registrationfee = FeeCategoryAmount::where('fee_category_id', $fee_category_id)->where('class_id', $std->class_id)->first();

            $accountstudentfees = AccountsStudentsFee::where('student_id', $std->student_id)->where('year_id', $std->year_id)->where('class_id', $std->class_id)->where('fee_category_id', $fee_category_id)->where('date', $date)->first();

            if ($accountstudentfees != null) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            $color = 'success';
            $html[$key]['tdsource']  = '<td>' . $std['student']['id_no'] . '<input type="hidden" name="fee_category_id" value= " ' . $fee_category_id . ' " >' . '</td>';

            $html[$key]['tdsource']  .= '<td>' . $std['student']['name'] . '<input type="hidden" name="year_id" value= " ' . $std->year_id . ' " >' . '</td>';

            $html[$key]['tdsource']  .= '<td>' . $std['student']['fname'] . '<input type="hidden" name="class_id" value= " ' . $std->class_id . ' " >' . '</td>';

            $html[$key]['tdsource']  .= '<td>' . $registrationfee->amount . 'KSH' . '<input type="hidden" name="date" value= " ' . $date . ' " >' . '</td>';

            $html[$key]['tdsource'] .= '<td>' . $std['discount']['discount'] . '%' . '</td>';

            $orginalfee = $registrationfee->amount;
            $discount = $std['discount']['discount'];
            $discountablefee = $discount / 100 * $orginalfee;
            $finalfee = (int)$orginalfee - (int)$discountablefee;

            $html[$key]['tdsource'] .= '<td>' . '<input type="text" name="amount[]" value="' . $finalfee . ' " class="form-control" readonly' . '</td>';

            $html[$key]['tdsource'] .= '<td>' . '<input type="hidden" name="student_id[]" value="' . $std->student_id . '">' . '<input type="checkbox" name="checkmanage[]" id="' . $key . '" value="' . $key . '" ' . $checked . ' style="transform: scale(1.5);margin-left: 10px;"> <label for="' . $key . '"> </label> ' . '</td>';
        }
        return response()->json(@$html);
    } // End

    public function StoreStudentFee(Request $request)
    {

        $date = date('Y-m', strtotime($request->date));

        AccountsStudentsFee::where('year_id', $request->year_id)->where('class_id', $request->class_id)->where('fee_category_id', $request->fee_category_id)->where('date', $request->date)->delete();

        $checkdata = $request->checkmanage;

        if ($checkdata != null) {
            for ($i = 0; $i < count($checkdata); $i++) {
                $data = new AccountsStudentsFee();
                $data->year_id = $request->year_id;
                $data->class_id = $request->class_id;
                $data->date = $date;
                $data->fee_category_id = $request->fee_category_id;
                $data->student_id = $request->student_id[$checkdata[$i]];
                $data->amount = $request->amount[$checkdata[$i]];
                $data->save();
            } // end for loop
        } // end if 

        if (!empty(@$data) || empty($checkdata)) {

            $notification = array(
                'message' => ' Data Successfully Updated',
                'alert-type' => 'success'
            );

            return redirect()->route('student.fee.view')->with($notification);
        } else {

            $notification = array(
                'message' => 'Sorry Data not Saved',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    } //END


}