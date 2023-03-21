<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Models\User;
use App\Models\LeaveType;
use App\Models\LeavePurpose;
use Illuminate\Http\Request;
use App\Models\EmployeeLeave;
use App\Http\Controllers\Controller;

class EmployeeLeaveController extends Controller
{
    //
    public function LeaveView()
    {
        $data['allData'] = EmployeeLeave::orderBy('id', 'desc')->get();
        return view('backend.employees.employee_leave.employee_leave_view', $data);
    } //End

    public function LeaveAdd()
    {

        $data['employees'] = User::where('userType', 'Employee')->get();
        $data['leave_purpose'] = LeavePurpose::all();
        $data['leave_type'] = LeaveType::all();
        return view('backend.employees.employee_leave.employee_leave_add', $data);
    } //End

    public function LeaveStore(Request $request)
    {


        // $type = new LeaveType();
        // $leave_type_id = $type->name;
        // $type->name = $leave_type_id;
        // $type->save();


        if ($request->leave_purpose_id == "0") {
            $leavepurpose = new LeavePurpose();
            $leavepurpose->name = $request->name;
            $leavepurpose->save();
            $leave_purpose_id = $leavepurpose->id;
        } else {
            $leave_purpose_id = $request->leave_purpose_id;
        }


        $data = new EmployeeLeave();
        $data->employee_id = $request->employee_id;
        $data->leave_type_id = $request->leave_type_id;

        $data->leave_purpose_id = $leave_purpose_id;
        $data->start_date = date('Y-m-d', strtotime($request->start_date));
        $data->end_date = date('Y-m-d', strtotime($request->end_date));
        $data->save();

        $notification = array(
            'message' => 'Employee Leave Data Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.leave.view')->with($notification);
    } // end Method 


     public function LeaveEdit($id){
    	$data['editData'] = EmployeeLeave::find($id);
    	$data['employees'] = User::where('userType','Employee')->get();
    	$data['leave_purpose'] = LeavePurpose::all();
    	return view('backend.employees.employee_leave.employee_leave_edit',$data);

    }



    public function LeaveUpdate(Request $request,$id){

    	if ($request->leave_purpose_id == "0") {
    		$leavepurpose = new LeavePurpose();
    		$leavepurpose->name = $request->name;
    		$leavepurpose->save();
    		$leave_purpose_id = $leavepurpose->id;
    	}else{
    		$leave_purpose_id = $request->leave_purpose_id;
    	}

    	$data = EmployeeLeave::find($id);
    	$data->employee_id = $request->employee_id;
    	$data->leave_purpose_id = $leave_purpose_id;
    	$data->start_date = date('Y-m-d',strtotime($request->start_date));
    	$data->end_date = date('Y-m-d',strtotime($request->end_date));
    	$data->save();

    	$notification = array(
    		'message' => 'Employee Leave Data Updated Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('employee.leave.view')->with($notification);

    } // end Method 

     public function LeaveDelete($id){
    	$leave = EmployeeLeave::find($id);
    	$leave->delete();

    	$notification = array(
    		'message' => 'Employee Leave Data Deleted Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('employee.leave.view')->with($notification);
    }
}