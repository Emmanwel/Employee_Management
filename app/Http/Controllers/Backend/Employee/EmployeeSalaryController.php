<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Models\EmployeeSallaryLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeSalaryController extends Controller
{
    //

    public function SalaryView()
    {
        $data['allData'] = User::where('userType', 'Employee')->get();
        return view('backend.employees.employee_salary.employee_salary_view', $data);
    } //End Method

    public function SalaryIncrement($id)
    {
        $data['editData'] = User::find($id);
        //$data['editSalary'] = EmployeeSallaryLog::find($id);
        return view('backend.employees.employee_salary.employee_salary_increment', $data);
    } //End Method

    public function StoreSalary(Request $request, $id)
    {
        $user = User::find($id);
        $previous_salary = $user->salary;
        $present_salary = (float) $previous_salary + (float) $request->increment_salary;
        $user->salary = $present_salary;
        $user->save();

        $salaryData = new EmployeeSallaryLog();
        $salaryData->employee_id = $id;
        $salaryData->previous_salary = $previous_salary;
        $salaryData->increment_salary = $request->increment_salary;
        $salaryData->present_salary = $present_salary;
        $salaryData->effected_salary = date('Y-m-d', strtotime($request->effected_salary));
        $salaryData->save();

        $notification = [
            'message' => 'Salary Incremented Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('employee.salary.view')->with($notification);
    } //End
    public function SalaryDetails($id)
    {
        $data['details'] = User::find($id);
        $data['salary_log'] = EmployeeSallaryLog::where('employee_id', $data['details']->id)->get();
        //dd($data['salary_log']->toArray());
        return view('backend.employees.employee_salary.employee_salary_details', $data);
    } //END
}