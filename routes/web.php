<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdminController;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DefaultController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\Marks\GradeController;
use App\Http\Controllers\Backend\Marks\MarksController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Backend\Setup\SubjectController;
use App\Http\Controllers\Backend\Setup\ExamTypeController;
use App\Http\Controllers\Backend\Header\CalendarController;
use App\Http\Controllers\Backend\Setup\FeeAmountController;
use App\Http\Controllers\Backend\Setup\LeaveTypeController;
use App\Http\Controllers\Backend\Student\ExamFeeController;
use App\Http\Controllers\Backend\Payments\PaymentController;
use App\Http\Controllers\Backend\Setup\DesignationController;
use App\Http\Controllers\Backend\Setup\FeeCategoryController;
use App\Http\Controllers\Backend\Setup\StudentYearController;
use App\Http\Controllers\Backend\Account\OtherCostsController;
use App\Http\Controllers\Backend\Account\StudentFeeController;
use App\Http\Controllers\Backend\Setup\StudentClassController;
use App\Http\Controllers\Backend\Setup\StudentGroupController;
use App\Http\Controllers\Backend\Setup\StudentShiftController;
use App\Http\Controllers\Backend\Student\MonthlyFeeController;
use App\Http\Controllers\Backend\Student\StudentRegController;
use App\Http\Controllers\Backend\Setup\AssignSubjectController;
use App\Http\Controllers\Backend\Employee\EmployeeRegController;
use App\Http\Controllers\Backend\student\GenerateRollController;
use App\Http\Controllers\Backend\Account\AccountSalaryController;
use App\Http\Controllers\Backend\Employee\EmployeeLeaveController;
use App\Http\Controllers\Backend\Employee\MonthlySalaryController;
use App\Http\Controllers\Backend\Employee\EmployeeSalaryController;
use App\Http\Controllers\Backend\student\RegistrationFeeController;
use App\Http\Controllers\Backend\Employee\EmployeeAttendanceController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('admin.index');
// })->name('dashboard');


//Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


//Password Reset Link Routes

// Route::get('/forgot-password', function () {
//     return view('auth.forgot-password');
// })->middleware('guest')->name('password.request');


// Route::post('/forgot-password', function (Request $request) {
//     $request->validate(['email' => 'required|email']);

//     $status = Password::sendResetLink(
//         $request->only('email')
//     );

//     return $status === Password::RESET_LINK_SENT
//         ? back()->with(['status' => __($status)])
//         : back()->withErrors(['email' => __($status)]);
// })->middleware('guest')->name('password.email');


// Route::get('/reset-password/{token}', function (string $token) {
//     return view('auth.reset-password', ['token' => $token]);
// })->middleware('guest')->name('password.reset');



// Route::post('/reset-password', function (Request $request) {
//     $request->validate([
//         'token' => 'required',
//         'email' => 'required|email',
//         'password' => 'required|min:8|confirmed',
//     ]);

//     $status = Password::reset(
//         $request->only('email', 'password', 'password_confirmation', 'token'),
//         function (User $user, string $password) {
//             $user->forceFill([
//                 'password' => Hash::make($password)
//             ])->setRememberToken(Str::random(60));

//             $user->save();

//             event(new PasswordReset($user));
//         }
//     );

//     return $status === Password::PASSWORD_RESET
//         ? redirect()->route('login')->with('status', __($status))
//         : back()->withErrors(['email' => [__($status)]]);
// })->middleware('guest')->name('password.update');

// End Pasword Reset






Route::get('admin/logout', [AdminController::class, 'Logout'])->name('admin.logout');

//Auth Middleware to restrict users from accesing these pages without login
Route::group(['middleware'  => 'auth', 'verified'], function () {


    //USER MANAGEMENT ALL ROUTES.

    // Route::get('view/user', [UserController::class, 'UserView'])->name('users.view');

    //Group My Routes
    Route::prefix('users')->group(function () {
        Route::get('/view', [UserController::class, 'UserView'])->name('users.view');
        Route::get('/add', [UserController::class, 'AddUser'])->name('users.add');
        Route::post('/store', [UserController::class, 'StoreUser'])->name('users.store');
        Route::get('/edit/{id}', [UserController::class, 'EditUser'])->name('users.edit');
        Route::post('/update/{id}', [UserController::class, 'UpdateUser'])->name('users.update');
        Route::get('/delete/{id}', [UserController::class, 'DeleteUser'])->name('users.delete');
    });

    //Socialite Logins Github and Google

    Route::get('/auth/redirect', function () {
        return Socialite::driver('github')->redirect();
    });

    Route::get('/auth/callback', function () {
        $githubUser = Socialite::driver('github')->user();

        // $user->token

        $user = User::updateOrCreate(
            [
                'github_id' => $githubUser->id,
            ],
            [
                'name' => $githubUser->name,
                'email' => $githubUser->email,
                'github_token' => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
            ],
        );

        Auth::login($user);

        return redirect('/');
    });

    Route::get('/auth/redirect', function () {
        return Socialite::driver('google')->redirect();
    });

    Route::get('/auth/callback', function () {
        $googleUser = Socialite::driver('google')->user();

        // $user->token

        $user = User::updateOrCreate(
            [
                'google_id' => $googleUser->id,
            ],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ],
        );

        Auth::login($user);

        return redirect('/');
    });



    //Notifications Routes

    Route::post('/deposit', [App\Http\Controllers\Backend\Notifications\DepositController::class, 'deposit'])->name('deposit');
    Route::get('/mark-as-read', [DepositController::class, 'markAsRead'])->name('mark-as-read');

    //User Profile and Change Password Routes

    Route::prefix('profile')->group(function () {
        Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profile.view');
        Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'StoreProfile'])->name('profile.store');
        Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
    });

    //Calender routes

    Route::prefix('calender')->group(function () {
        Route::get('/view', [CalendarController::class, 'CalenderView'])->name('calender.view');
        Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'StoreProfile'])->name('profile.store');
        Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
    });

    //Student Class Routes

    Route::prefix('setups')->group(function () {
        Route::get('student/class/view', [StudentClassController::class, 'ViewStudent'])->name('student.class.view');
        Route::get('student/class/add', [StudentClassController::class, 'AddStudentClass'])->name('student.class.add');
        Route::post('student/class/store', [StudentClassController::class, 'StoreStudentClass'])->name('store.student.class');
        Route::get('student/class/edit/{id}', [StudentClassController::class, 'EditStudentClass'])->name('student.class.edit');
        Route::post('student/class/update/{id}', [StudentClassController::class, 'UpdateStudentClass'])->name('update.student.class');
        Route::get('student/class/delete/{id}', [StudentClassController::class, 'DeleteStudentClass'])->name('delete.student.class');

        //Student Year Routes

        Route::get('student/year/view', [StudentYearController::class, 'ViewStudentYear'])->name('student.year.view');
        Route::get('student/year/add', [StudentYearController::class, 'AddStudentYear'])->name('student.year.add');
        Route::post('student/year/store', [StudentYearController::class, 'StoreStudentYear'])->name('store.student.year');
        Route::get('student/year/edit/{id}', [StudentYearController::class, 'EditStudentYear'])->name('student.year.edit');
        Route::post('student/year/update/{id}', [StudentYearController::class, 'UpdateStudentYear'])->name('update.student.year');
        Route::get('student/year/update/{id}', [StudentYearController::class, 'DeleteStudentYear'])->name('delete.student.year');

        //Student Group Routes
        Route::get('student/group/view', [StudentGroupController::class, 'ViewStudentGroup'])->name('student.group.view');
        Route::get('student/group/add', [StudentGroupController::class, 'AddStudentGroup'])->name('student.group.add');
        Route::post('student/group/store', [StudentGroupController::class, 'StoreStudentGroup'])->name('store.student.group');
        Route::get('student/group/edit/{id}', [StudentGroupController::class, 'EditStudentGroup'])->name('student.group.edit');
        Route::post('student/group/update/{id}', [StudentGroupController::class, 'UpdateStudentGroup'])->name('update.student.group');
        Route::get('student/group/update/{id}', [StudentGroupController::class, 'DeleteStudentGroup'])->name('delete.student.group');

        //Student Shift Routes

        Route::get('student/shift/view', [StudentShiftController::class, 'ViewShift'])->name('student.shift.view');
        Route::get('student/shift/add', [StudentShiftController::class, 'AddStudentShift'])->name('student.shift.add');
        Route::post('student/shift/store', [StudentShiftController::class, 'StoreStudentShift'])->name('store.student.shift');
        Route::get('student/shift/edit/{id}', [StudentShiftController::class, 'EditStudentShift'])->name('student.shift.edit');
        Route::post('student/shift/update/{id}', [StudentShiftController::class, 'UpdateStudentShift'])->name('update.student.shift');
        Route::get('student/shift/update/{id}', [StudentShiftController::class, 'DeleteStudentShift'])->name('delete.student.shift');

        // Fee Category Routes

        Route::get('fee/category/view', [FeeCategoryController::class, 'ViewFeeCat'])->name('fee.category.view');
        Route::get('fee/category/add', [FeeCategoryController::class, 'AddFeeCat'])->name('fee.category.add');
        Route::post('fee/category/store', [FeeCategoryController::class, 'StoreFeeCat'])->name('store.fee.category');
        Route::get('fee/category/edit/{id}', [FeeCategoryController::class, 'EditFeeCat'])->name('fee.category.edit');
        Route::post('fee/category/update/{id}', [FeeCategoryController::class, 'UpdateFeeCategory'])->name('update.fee.category');
        Route::get('fee/category/delete/{id}', [FeeCategoryController::class, 'DeleteFeeCategory'])->name('delete.fee.category');

        //Fee Amount Catewgory Controller

        Route::get('fee/amount/view', [FeeAmountController::class, 'ViewFeeAmount'])->name('fee.amount.view');
        Route::get('fee/amount/add', [FeeAmountController::class, 'AddFeeAmount'])->name('fee.amount.add');
        Route::post('fee/amount/store', [FeeAmountController::class, 'StoreFeeAmount'])->name('store.fee.amount');
        Route::get('fee/amount/edit/{fee_category_id}', [FeeAmountController::class, 'EditFeeAmount'])->name('fee.amount.edit');
        Route::post('fee/amount/update/{fee_category_id}', [FeeAmountController::class, 'UpdateFeeAmount'])->name('update.fee.amount');
        Route::get('fee/amount/details/{fee_category_id}', [FeeAmountController::class, 'DetailsFeeAmount'])->name('fee.amount.details');

        // Exam Type Routes

        Route::get('exam/type/view', [ExamTypeController::class, 'ViewExamType'])->name('exam.type.view');
        Route::get('exam/type/add', [ExamTypeController::class, 'AddExamType'])->name('exam.type.add');
        Route::post('exam/type/store', [ExamTypeController::class, 'StoreExamType'])->name('store.exam.type');
        Route::get('exam/type/edit/{id}', [ExamTypeController::class, 'EditExamType'])->name('exam.type.edit');
        Route::post('exam/type/update/{id}', [ExamTypeController::class, 'UpdateExamType'])->name('update.exam.type');
        Route::get('exam/type/delete/{id}', [ExamTypeController::class, 'DeleteExamType'])->name('exam.type.delete');

        // School Subject All Routes

        Route::get('school/subject/view', [SubjectController::class, 'ViewSubject'])->name('school.subject.view');
        Route::get('school/subject/add', [SubjectController::class, 'AddSubject'])->name('school.subject.add');
        Route::post('school/subject/store', [SubjectController::class, 'StoreSubject'])->name('store.school.subject');
        Route::get('school/subject/edit/{id}', [SubjectController::class, 'EditSubject'])->name('school.subject.edit');
        Route::post('school/subject/update/{id}', [SubjectController::class, 'UpdateSubject'])->name('update.school.subject');
        Route::get('school/subject/delete/{id}', [SubjectController::class, 'DeleteSubject'])->name('school.subject.delete');

        // Assign Subject Routes

        Route::get('assign/subject/view', [AssignSubjectController::class, 'ViewAssignSubject'])->name('assign.subject.view');
        Route::get('assign/subject/add', [AssignSubjectController::class, 'AddAssignSubject'])->name('assign.subject.add');
        Route::post('assign/subject/store', [AssignSubjectController::class, 'StoreAssignSubject'])->name('store.assign.subject');
        Route::get('assign/subject/edit/{class_id}', [AssignSubjectController::class, 'EditAssignSubject'])->name('assign.subject.edit');
        Route::post('assign/subject/update/{class_id}', [AssignSubjectController::class, 'UpdateAssignSubject'])->name('update.assign.subject');
        Route::get('assign/subject/details/{class_id}', [AssignSubjectController::class, 'DetailsAssignSubject'])->name('assign.subject.details');

        // Designation All Routes

        Route::get('designation/view', [DesignationController::class, 'ViewDesignation'])->name('designation.view');
        Route::get('designation/add', [DesignationController::class, 'DesignationAdd'])->name('designation.add');
        Route::post('designation/store', [DesignationController::class, 'DesignationStore'])->name('store.designation');
        Route::get('designation/edit/{id}', [DesignationController::class, 'DesignationEdit'])->name('designation.edit');
        Route::post('designation/update/{id}', [DesignationController::class, 'DesignationUpdate'])->name('update.designation');
        Route::get('designation/delete/{id}', [DesignationController::class, 'DesignationDelete'])->name('designation.delete');

        // Leave Type All Routes

        Route::get('leave/type/view', [LeaveTypeController::class, 'ViewLeaveType'])->name('leave.type.view');
        Route::get('leave/type/add', [LeaveTypeController::class, 'AddLeaveType'])->name('leave.type.add');
        Route::post('leave/type/store', [LeaveTypeController::class, 'StoreLeaveType'])->name('store.leave.type');
        Route::get('leave/type/edit/{id}', [LeaveTypeController::class, 'EditLeaveType'])->name('leave.type.edit');
        Route::post('leave/type/update/{id}', [LeaveTypeController::class, 'UpdateLeaveType'])->name('update.leave.type');
        Route::get('leave/type/delete/{id}', [LeaveTypeController::class, 'DeleteLeaveType'])->name('leave.type.delete');
    });

    //Student Registration Routes

    Route::prefix('students')->group(function () {
        Route::get('/reg/view', [StudentRegController::class, 'StudentRegView'])->name('student.registration.view');
        Route::get('/reg/add', [StudentRegController::class, 'StudentRegAdd'])->name('student.registration.add');
        Route::post('/reg/store', [StudentRegController::class, 'StudentRegStore'])->name('store.student.registration');
        Route::get('/year/class/search', [StudentRegController::class, 'StudentClassYearSearch'])->name('student.year.class.search');
        Route::get('/edit/details/{student_id}', [StudentRegController::class, 'EditStudentDetails'])->name('student.registration.edit');
        Route::post('/update/details/{student_id}', [StudentRegController::class, 'UpdateStudentDetails'])->name('update.student.registration');
        Route::get('/promotion/{student_id}', [StudentRegController::class, 'PromoteStudent'])->name('promote.student');
        Route::post('/update/promotion/{student_id}', [StudentRegController::class, 'UpdateStudentPromotion'])->name('update.student.promotion');
        Route::get('/details/{student_id}/pdf', [StudentRegController::class, 'GenerateStudentDetailsPDF'])->name('generate.details.pdf');
    });

    //Roll Routes
    Route::prefix('generate')->group(function () {
        Route::get('/roll/view', [GenerateRollController::class, 'GenerateRollView'])->name('view.generated.roll');
        Route::get('/get/allstudents', [GenerateRollController::class, 'GetStudents'])->name('student.registration.getstudents');
        Route::post('/roll/storage', [GenerateRollController::class, 'StudentRollStore'])->name('roll.generate.store');
    });

    //Registration Fee Routes
    Route::prefix('reg')->group(function () {
        Route::get('/fee/view', [RegistrationFeeController::class, 'RegFeeView'])->name('registration.fee.view');
        Route::get('/get/fees', [RegistrationFeeController::class, 'RegFeeClassData'])->name('student.registration.fee.byclass.get');
        Route::get('/fee/slip', [RegistrationFeeController::class, 'RegFeePayslip'])->name('student.registration.fee.slip');
    });

    //Monthly Fee Routes
    Route::prefix('fee')->group(function () {
        Route::get('/monthly/view', [MonthlyFeeController::class, 'MonthlyFeeView'])->name('monthly.fee.view');
        Route::get('/monthly/details', [MonthlyFeeController::class, 'MonthlyFeeData'])->name('student.monthly.fee.byclass.get');
        Route::get('/monthly/slip', [MonthlyFeeController::class, 'MonthlyFeePayslip'])->name('student.monthly.fee.slip');
    });

    Route::prefix('exam')->group(function () {

        Route::get('/fee/view', [ExamFeeController::class, 'ExamFeeView'])->name('exam.fee.view');
        Route::get('/fee/details', [ExamFeeController::class, 'ExamFeeClassData'])->name('student.exam.fee.byclass.get');
        Route::get('/fee/slip', [ExamFeeController::class, 'ExamFeePayslip'])->name('student.exam.fee.slip');
    });


    //Employee Routes


    Route::prefix('employees')->group(function () {

        Route::get('/reg/view', [EmployeeRegController::class, 'EmployeeRegView'])->name('employee.registration.view');
        Route::get('/reg/add', [EmployeeRegController::class, 'AddEmployee'])->name('employee.registration.add');
        Route::post('/reg/store', [EmployeeRegController::class, 'StoreEmployee'])->name('store.employee.registration');
        Route::get('/reg/edit/{id}', [EmployeeRegController::class, 'EditEmployee'])->name('employee.registration.edit');
        Route::post('/reg/update/{id}', [EmployeeRegController::class, 'UpdateEmployeeDetails'])->name('update.employee.registration');
        Route::get('/reg/details/{id}', [EmployeeRegController::class, 'ViewPDFofEmployeeDetails'])->name('employee.registration.details');


        //Salary Increment
        Route::get('salary/view', [EmployeeSalaryController::class, 'SalaryView'])->name('employee.salary.view');
        Route::get('salary/increment/{id}', [EmployeeSalaryController::class, 'SalaryIncrement'])->name('employee.salary.increment');
        Route::post('salary/store/{id}', [EmployeeSalaryController::class, 'StoreSalary'])->name('update.increment.store');
        Route::get('salary/details/{id}', [EmployeeSalaryController::class, 'SalaryDetails'])->name('employee.salary.details');



        // Employee Leave All Routes
        Route::get('leave/view', [EmployeeLeaveController::class, 'LeaveView'])->name('employee.leave.view');
        Route::get('leave/add', [EmployeeLeaveController::class, 'LeaveAdd'])->name('employee.leave.add');
        Route::post('leave/store', [EmployeeLeaveController::class, 'LeaveStore'])->name('store.employee.leave');
        Route::get('leave/edit/{id}', [EmployeeLeaveController::class, 'LeaveEdit'])->name('employee.leave.edit');
        Route::get('leave/approve/{id}', [EmployeeLeaveController::class, 'LeaveApprove'])->name('employee.leave.approve');
        Route::post('leave/update/{id}', [EmployeeLeaveController::class, 'LeaveUpdate'])->name('update.employee.leave');
        Route::get('leave/delete/{id}', [EmployeeLeaveController::class, 'LeaveDelete'])->name('employee.leave.delete');



        // Employee Attendance All Routes
        Route::get('attendance/view', [EmployeeAttendanceController::class, 'AttendanceView'])->name('employee.attendance.view');
        Route::get('attendance/add', [EmployeeAttendanceController::class, 'AttendanceAdd'])->name('employee.attendance.add');
        Route::post('attendance/store', [EmployeeAttendanceController::class, 'AttendanceStore'])->name('store.employee.attendance');
        Route::get('attendance/edit/{date}', [EmployeeAttendanceController::class, 'AttendanceEdit'])->name('employee.attendance.edit');
        Route::get('attendance/details/{date}', [EmployeeAttendanceController::class, 'AttendanceDetails'])->name('employee.attendance.details');

        // Employee Monthly Salary All Routes
        Route::get('monthly/salary/view', [MonthlySalaryController::class, 'MonthlySalaryView'])->name('employee.monthly.salary');
        Route::get('monthly/salary/get', [MonthlySalaryController::class, 'MonthlySalaryGet'])->name('employee.monthly.salary.get');
        Route::get('monthly/salary/payslip/{employee_id}', [MonthlySalaryController::class, 'MonthlySalaryPayslip'])->name('employee.monthly.salary.payslip');
    });


    //Manage Marks  All My Routes
    Route::prefix('marks')->group(function () {
        Route::get('entry/add', [MarksController::class, 'MarksAdd'])->name('marks.entry.add');
        Route::post('marks/entry/store', [MarksController::class, 'MarksStore'])->name('marks.entry.store');
        Route::get('entry/edit', [MarksController::class, 'MarksEdit'])->name('marks.entry.edit');
        Route::get('getstudents/edit', [MarksController::class, 'MarksEditGetStudents'])->name('student.edit.getstudents');
        Route::post('entry/update', [MarksController::class, 'MarksUpdate'])->name('marks.entry.update');


        // Marks Entry Grade
        Route::get('marks/grade/view', [GradeController::class, 'MarksGradeView'])->name('marks.entry.grade');
        Route::get('marks/grade/add', [GradeController::class, 'MarksGradeAdd'])->name('marks.grade.add');
        Route::post('marks/grade/store', [GradeController::class, 'MarksGradeStore'])->name('store.marks.grade');
        Route::get('marks/grade/edit/{id}', [GradeController::class, 'MarksGradeEdit'])->name('marks.grade.edit');
        Route::post('marks/grade/update/{id}', [GradeController::class, 'MarksGradeUpdate'])->name('update.marks.grade');
    });

    Route::get('marks/getsubject', [DefaultController::class, 'GetSubject'])->name('marks.getsubject');
    Route::get('student/marks/getstudents', [DefaultController::class, 'GetStudents'])->name('student.marks.getstudents');


    // Account Management Routes
    Route::prefix('accounts')->group(function () {
        Route::get('student/fee/view', [StudentFeeController::class, 'ViewStudentFee'])->name('student.fee.view');
        Route::get('student/fee/add', [StudentFeeController::class, 'AddStudentFee'])->name('student.fee.add');
        Route::get('student/fee/getstudent', [StudentFeeController::class, 'StudentFeeGetStudent'])->name('account.fee.getstudent');
        Route::post('student/fee/store', [StudentFeeController::class, 'StoreStudentFee'])->name('account.fee.store');


        // Employee Salary Routes
        Route::get('employee/salary/view', [AccountSalaryController::class, 'ViewEmployeeAccountSalary'])->name('account.salary.view');
        Route::get('employee/salary/add', [AccountSalaryController::class, 'AddEditEmployeeAccountSalary'])->name('account.salary.add');
        Route::get('employee/salary/getemployee', [AccountSalaryController::class, 'GetEmployeeAccountSalary'])->name('account.salary.getemployee');
        Route::post('employee/salary/store', [AccountSalaryController::class, 'StoreAccountSalary'])->name('account.salary.store');

        // Other Cost Routes
        Route::get('other/cost/view', [OtherCostsController::class, 'ViewOtherCosts'])->name('other.cost.view');
        Route::get('other/cost/add', [OtherCostsController::class, 'AddOtherCosts'])->name('other.cost.add');
        Route::post('other/cost/store', [OtherCostsController::class, 'StoreOtherCosts'])->name('store.other.cost');
        Route::get('other/cost/edit/{id}', [OtherCostsController::class, 'EditOtherCosts'])->name('edit.other.cost');
        Route::post('other/cost/update/{id}', [OtherCostsController::class, 'UpdateOtherCosts'])->name('update.other.cost');
    });


    //Payment routes
    Route::prefix('payments')->group(function () {
        Route::get('generateAccessToken', [PaymentController::class, 'generateAccessToken'])->name('generateAccessToken');
        // Route::get('initiatepush', [PaymentController::class, 'initiateStkPush'])->name('initiatepush');
        Route::post('stkcallback', [PaymentController::class, 'stkCallback'])->name('stkcallback');
        Route::get('stkquery', [PaymentController::class, 'stkQuery'])->name('stkquery');
        Route::get('registerurl', [PaymentController::class, 'registerUrl'])->name('registerurl');
        Route::post('validation', [PaymentController::class, 'Validation'])->name('validation');
        Route::post('confirmation', [PaymentController::class, 'Confirmation'])->name('confirmation');
        Route::get('simulate', [PaymentController::class, 'Simulate'])->name('simulate');
        Route::get('qrcode', [PaymentController::class, 'QRCode'])->name('qrcode');
        Route::get('b2c', [PaymentController::class, 'b2c'])->name('b2c');
        Route::post('b2cresult', [PaymentController::class, 'b2cResult'])->name('b2cresult');
        Route::post('b2ctimeout', [PaymentController::class, 'b2cTimeout'])->name('b2ctimeout');
    });


    Route::prefix('fetch')->group(function () {
        Route::get('student/marks', [MarksController::class, 'marks'])->name('marks.view');
        Route::get('student/fees', [StudentRegController::class, 'showFees'])->name('fees.view');

        Route::get('payment/fees', [PaymentController::class, 'initiateStkPush'])->name('simulate');


        // Route::get('payments/fees', [PaymentController::class, 'FeesPayments'])->name('simulate');
    });
}); //End of Auth middleware