<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Models\User;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\EmployeeSallaryLog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmployeeRegController extends Controller
{
    //
    public function EmployeeRegView()
    {
        //Fetch data from the Users Table.
        $data['allData'] = User::where('userType', 'Employee')->get();
        return view('backend.employees.employee_reg.employee_view', $data);
    } //End
    public function AddEmployee()
    {
        $data['allData'] = User::all();
        $data['designation'] = Designation::all();
        return view('backend.employees.employee_reg.employee_add', $data);
    } //End

    public function StoreEmployee(Request $request)
    {
        DB::transaction(function () use ($request) {
            $checkYear = date('Ym', strtotime($request->join_date));
            //dd($checkYear);
            $employee = User::where('userType', 'Employee')
                ->orderBy('id', 'DESC')
                ->first();

            if ($employee == null) {
                $firstReg = 0;
                $employeeId = $firstReg + 1;
                if ($employeeId < 10) {
                    $id_no = '000' . $employeeId;
                } elseif ($employeeId < 100) {
                    $id_no = '00' . $employeeId;
                } elseif ($employeeId < 1000) {
                    $id_no = '0' . $employeeId;
                }
            } else {
                $employee = User::where('userType', 'Employee')
                    ->orderBy('id', 'DESC')
                    ->first()->id;
                $employeeId = $employee + 1;
                if ($employeeId < 10) {
                    $id_no = '000' . $employeeId;
                } elseif ($employeeId < 100) {
                    $id_no = '00' . $employeeId;
                } elseif ($employeeId < 1000) {
                    $id_no = '0' . $employeeId;
                }
            } // end else

            $final_id_no = $checkYear . $id_no;
            $user = new User();
            $code = rand(0000, 9999);
            $user->id_no = $final_id_no;
            $user->password = bcrypt($code);
            $user->userType = 'Employee';
            $user->code = $code;
            $user->name = $request->name;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->salary = $request->salary;
            $user->designation_id = $request->designation_id;
            $user->dob = date('Y-m-d', strtotime($request->dob));
            $user->join_date = date('Y-m-d', strtotime($request->join_date));

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/employee_images'), $filename);
                $user['image'] = $filename;
            }
            $user->save();

            //Generate random order number
            $checkYear = date('Y', strtotime($request->join_date));

            $final_order_no = 'EMP' . $id_no;

            $employee_salary = new EmployeeSallaryLog();
            //$ordercodes = rand(0000, 9999);
            // $user->password = bcrypt($code);
            $employee_salary->employee_id = $user->id;
            $employee_salary->effected_salary = date('Y-m-d', strtotime($request->join_date));
            $employee_salary->previous_salary = $request->salary;
            $employee_salary->present_salary = $request->salary;
            $employee_salary->increment_salary = '0';
            $employee_salary->autogenerated_orders = $final_order_no;
            $employee_salary->code = $code;
            $employee_salary->save();
        });

        $notification = [
            'message' => 'Employee Registered Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('employee.registration.view')
            ->with($notification);
    } // End Method

    public function EditEmployee($id)
    {
        $data['editData'] = User::find($id);
        $data['designation'] = Designation::all();
        return view('backend.employees.employee_reg.employee_edit', $data);
    } //End

    public function UpdateEmployeeDetails(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->religion = $request->religion;

        $user->designation_id = $request->designation_id;
        $user->dob = date('Y-m-d', strtotime($request->dob));

        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/employee_images/' . $user->image));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/employee_images'), $filename);
            $user['image'] = $filename;
        }
        $user->save();

        $employee_salary = EmployeeSallaryLog::where('employee_id', $request->id)->first();

        $employee_salary->effected_salary = date('Y-m-d', strtotime($request->join_date));
        $employee_salary->previous_salary = $request->salary;
        $employee_salary->present_salary = $request->salary;
        $employee_salary->increment_salary = '0';
        $employee_salary->save();

        $notification = [
            'message' => 'Employee Details Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('employee.registration.view')
            ->with($notification);
    } // END

    public function ViewPDFofEmployeeDetails($id)
    {
        $data['details'] = User::find($id);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('backend.employees.employee_reg.employee_details_pdf', $data);

        // $pdf = PDF::loadView('backend.employee.employee_reg.employee_details_pdf', $data);
        // $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } //END Method
}