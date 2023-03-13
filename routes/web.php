<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\Setup\SubjectController;
use App\Http\Controllers\Backend\Setup\ExamTypeController;
use App\Http\Controllers\Backend\Setup\FeeAmountController;
use App\Http\Controllers\Backend\Setup\DesignationController;
use App\Http\Controllers\Backend\Setup\FeeCategoryController;
use App\Http\Controllers\Backend\Setup\StudentYearController;
use App\Http\Controllers\Backend\Setup\StudentClassController;
use App\Http\Controllers\Backend\Setup\StudentGroupController;
use App\Http\Controllers\Backend\Setup\StudentShiftController;
use App\Http\Controllers\Backend\Setup\AssignSubjectController;

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

Route::middleware([
    'auth:sanctum', config('jetstream.auth_session'), 'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('admin.index');
// })->name('dashboard');


Route::get('admin/logout', [AdminController::class, 'Logout'])->name('admin.logout');

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

    $user = User::updateOrCreate([
        'github_id' => $githubUser->id,
    ], [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
    ]);

    Auth::login($user);

    return redirect('/');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    // $user->token

    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
    ]);

    Auth::login($user);

    return redirect('/');
});

//User Profile and Change Password Routes

Route::prefix('profile')->group(function () {
    Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profile.view');
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
    Route::get('student/class/update/{id}', [StudentClassController::class, 'DeleteStudentClass'])->name('delete.student.class');

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
});