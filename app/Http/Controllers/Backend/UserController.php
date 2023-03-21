<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class UserController extends Controller
{
    //
    public function UserView()
    {
        // $allData = User::all();
        // $data['allData'] = User::all();
        $data['allData'] = User::where('userType', 'Admin')->get();
        return view('backend.user.view_user', $data);
    }
    public function AddUser()
    {
        return view('backend.user.add_user');
    }
    public function StoreUser(Request $request)
    {

        //Perfom some Valiadations
        $validatedData = $request->validate(
            [
                'email' => 'required|unique:users',
                'name' => 'required',
            ],
            [
                'email.required' => 'Email Address Required',
                'name.required' => 'Name is Mandatory ',
            ]
        );

        $data = new User();
        //generate random password
        $code = rand(0000, 9999);
        $data->userType = 'Admin';
        $data->role = $request->role;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($code);
        $data->code = $code;
        $data->save();

        $notification = array(
            'message' => 'User Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('users.view')->with($notification);
    }
    public function EditUser($id)
    {
        $editData = User::find($id);
        return view('backend.user.edit_user', compact('editData'));
    }
    public function UpdateUser(Request $request, $id)
    {

        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->role = $request->role;

        $data->save();

        $notification = array(
            'message' => 'User Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('users.view')->with($notification);
    }


    public function DeleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        $notification = array(
            'message' => 'User Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('users.view')->with($notification);
    }
}
