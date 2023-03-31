<?php

namespace App\Http\Controllers\Backend\Account;

use Illuminate\Http\Request;
use App\Models\AccountsOtherCosts;
use App\Http\Controllers\Controller;

class OtherCostsController extends Controller
{
    //

    public function ViewOtherCosts()
    {
        $data['allData'] = AccountsOtherCosts::orderBy('id', 'desc')->get();
        return view('backend.accounts.other_cost.other_cost_view', $data);
    } //END

    public function AddOtherCosts()
    {
        return view('backend.accounts.other_cost.other_cost_add');
    } //END

    public function StoreOtherCosts(Request $request)
    {

        $cost = new AccountsOtherCosts();
        $cost->date = date('Y-m-d', strtotime($request->date));
        $cost->amount = $request->amount;

        if ($request->file('attachment')) {
            $file = $request->file('attachment');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/cost_images'), $filename);
            $cost['attachment'] = $filename;
        }
        $cost->description = $request->description;
        $cost->save();

        $notification = array(
            'message' => 'Other Cost Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('other.cost.view')->with($notification);
    }  // end method

    public function EditOtherCosts($id)
    {
        $data['editData'] = AccountsOtherCosts::find($id);
        return view('backend.accounts.other_cost.other_cost_edit', $data);
    } //end


    public function UpdateOtherCosts(Request $request, $id)
    {

        $cost = AccountsOtherCosts::find($id);
        $cost->date = date('Y-m-d', strtotime($request->date));
        $cost->amount = $request->amount;

        if ($request->file('attachment')) {
            $file = $request->file('attachment');
            @unlink(public_path('upload/cost_images/' . $cost->attachment));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/cost_images'), $filename);
            $cost['attachment'] = $filename;
        }
        $cost->description = $request->description;
        $cost->save();

        $notification = array(
            'message' => 'Other Cost Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('other.cost.view')->with($notification);
    } // end method 
}