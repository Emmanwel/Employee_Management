<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Models\FeeCategory;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\FeeCategoryAmount;
use App\Http\Controllers\Controller;

class FeeAmountController extends Controller
{
    //
    public function ViewFeeAmount()
    {
        //$data['allData'] = FeeCategoryAmount::all();
        $data['allData'] = FeeCategoryAmount::select('fee_category_id')->groupBy('fee_category_id')->get();
        return view('backend.setup.fee_amount.view_fee_amount', $data);
    }

    //End

    public function AddFeeAmount()
    {
        //Link the student category table and student class table
        $data['fee_categories'] = FeeCategory::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.fee_amount.add_fee_amount', $data);
    }

    //end


    public function StoreFeeAmount(Request $request)
    {

        $countClass = count($request->class_id);
        if ($countClass != NULL) {
            for ($i = 0; $i < $countClass; $i++) {
                $fee_amount = new FeeCategoryAmount();
                $fee_amount->fee_category_id = $request->fee_category_id;
                $fee_amount->class_id = $request->class_id[$i];
                $fee_amount->amount = $request->amount[$i];
                $fee_amount->save();
            } // End For Loop
        } // End If Condition

        $notification = array(
            'message' => 'Fee Amount Captured Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('fee.amount.view')->with($notification);
    }  // End Method 

    public function EditFeeAmount($fee_category_id)
    {
        $data['editData'] = FeeCategoryAmount::where('fee_category_id', $fee_category_id)->orderBy('class_id', 'asc')->get();
        // dd($data['editData']->toArray());
        $data['fee_categories'] = FeeCategory::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.fee_amount.edit_fee_amount', $data);
    }

    //end

    public function UpdateFeeAmount(Request $request, $fee_category_id)
    {
        if ($request->class_id == NULL) {

            $notification = array(
                'message' => 'You have to Select Class and Amount In Order to Update',
                'alert-type' => 'error'
            );

            return redirect()->route('fee.amount.edit', $fee_category_id)->with($notification);
        } else {

            $countClass = count($request->class_id);
            FeeCategoryAmount::where('fee_category_id', $fee_category_id)->delete();
            for ($i = 0; $i < $countClass; $i++) {
                $fee_amount = new FeeCategoryAmount();
                $fee_amount->fee_category_id = $request->fee_category_id;
                $fee_amount->class_id = $request->class_id[$i];
                $fee_amount->amount = $request->amount[$i];
                $fee_amount->save();
            } // End For Loop	 

        } // end Else

        $notification = array(
            'message' => 'Amount Details Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('fee.amount.view')->with($notification);
    } // end Method 

    public function DetailsFeeAmount($fee_category_id)
    {
        $data['detailsData'] = FeeCategoryAmount::where('fee_category_id', $fee_category_id)->orderBy('class_id', 'asc')->get();

        return view('backend.setup.fee_amount.details_fee_amount', $data);
    }
}
