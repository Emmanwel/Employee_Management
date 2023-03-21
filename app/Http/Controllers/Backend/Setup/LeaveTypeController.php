<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveTypeController extends Controller
{
    //

    public function ViewLeaveType()
    {
        $data['allData'] = LeaveType::all();
        return view('backend.setup.leave_type.view_leave_type', $data);
    }


    public function AddLeaveType()
    {
        return view('backend.setup.leave_type.add_leave_type');
    }


    public function StoreLeaveType(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|unique:leave_types,name',

        ]);

        $data = new LeaveType();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Leave Type Captured Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('leave.type.view')->with($notification);
    }



    public function EditLeaveType($id)
    {
        $editData = LeaveType::find($id);
        return view('backend.setup.leave_type.edit_leave_type', compact('editData'));
    }


    public function UpdateLeaveType(Request $request, $id)
    {

        $data = LeaveType::find($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:leave_types,name,' . $data->id

        ]);


        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Leave Type Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('leave.type.view')->with($notification);
    }


    public function DeleteLeaveType($id)
    {
        $user = LeaveType::find($id);
        $user->delete();

        $notification = array(
            'message' => 'Leave Type Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('leave.type.view')->with($notification);
    }
}