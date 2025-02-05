<?php

use App\FeesPaid;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Teacher;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::get('/profile/edit', 'HomeController@profileEdit')->name('profile.edit');
Route::put('/profile/update', 'HomeController@profileUpdate')->name('profile.update');
Route::get('/profile/changepassword', 'HomeController@changePasswordForm')->name('profile.change.password');
Route::post('/profile/changepassword', 'HomeController@changePassword')->name('profile.changepassword');

Route::group(['middleware' => ['auth','role:Admin']], function () 
{
    Route::get('/roles-permissions', 'RolePermissionController@roles')->name('roles-permissions');
    Route::get('/role-create', 'RolePermissionController@createRole')->name('role.create');
    Route::post('/role-store', 'RolePermissionController@storeRole')->name('role.store');
    Route::get('/role-edit/{id}', 'RolePermissionController@editRole')->name('role.edit');
    Route::put('/role-update/{id}', 'RolePermissionController@updateRole')->name('role.update');

    Route::get('/permission-create', 'RolePermissionController@createPermission')->name('permission.create');
    Route::post('/permission-store', 'RolePermissionController@storePermission')->name('permission.store');
    Route::get('/permission-edit/{id}', 'RolePermissionController@editPermission')->name('permission.edit');
    Route::put('/permission-update/{id}', 'RolePermissionController@updatePermission')->name('permission.update');

    Route::get('assign-subject-to-class/{id}', 'GradeController@assignSubject')->name('class.assign.subject');
    Route::post('assign-subject-to-class/{id}', 'GradeController@storeAssignedSubject')->name('store.class.assign.subject');
    Route::get('/librarybooks', [BookController::class, 'displayBooks'])->name('librarybooks');
    Route::get('/editbook/{id}', [BookController::class, 'edit'])->name('editbook');
    Route::put('/updatebook/{book}', [BookController::class, 'updateBook'])->name('updatebook');
    Route::delete('/delete', [BookController::class, 'deleteBook'])->name('deletebook');
    Route::get('/createbook', [BookController::class, 'showCreateBook']);
    Route::get('/students/{id}/print', [StudentController::class, 'printAdmissionLetter'])->name('student.print');
    Route::get("/showfees", [FeesController::class, 'show'])->name('fees.show');
    Route::post('/setfees', [FeesController::class, 'create'])->name('fees.set');
    Route::get("/collectfees", [FeesController::class, 'showcollectfees'])->name("fees.collect");
    Route::post('/feescollected',[FeesController::class, 'collectfees'])->name('fees.collected');
    Route::get('/fees/get-student-name', [FeesController::class, 'getStudentName'])->name('fees.get-student-name');
    Route::get('fees/defaulters', [FeesController::class, 'selectdefaulters'])->name('fees.defaulters');
    Route::post('/fees/defaulters', [FeesController::class, 'getdefaulters'])->name('defaulters.show');
    Route::get('/settings', [SettingsController::class, 'settings'])->name('settings.set');
    Route::post('/search/books/admin', [BookController::class,'searchBooks'])->name('search.books.admin');
    Route::post('/settings', [SettingsController::class, 'savesettings'])->name('settings.save');
    Route::post('/uploadbook',[BookController::class, 'uploadBook'])->name('upload.book');
    Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
    Route::get('/books/{book}/view', [BookController::class, 'viewOnline'])->name('books.view');
    Route::get('/pastquestions',[BookController::class, 'pastQuestions'])->name('past.questions');
    Route::get('/upload/pastquestions', [BookController::class, 'uploadPastQuestions'])->name('upload.pastquestions');
    Route::post('/save/pastquestions', [BookController::class, 'uploadExamsQuestions'])->name('pastquestions.store');
    Route::post('/search/pastquestions', [BookController::class, 'searchPastQuestions'])->name('search.questions');
    Route::get('/questions/{result}/view', [BookController::class, 'viewQuestionsOnline'])->name('questions.view');
    Route::post('/search/student', [StudentController::class, 'searchStudent'])->name('search.students');
    Route::get('/enquiries',[StudentController::class, 'studentEnquiry'])->name('student.enquires');
    Route::get('/create/enquiry', [StudentController::class, 'saveStudentEnquiry'])->name('enquiry.form');
    Route::post('/save/enquiry', [StudentController::class, 'storeEnquiry'])->name('store.enquiry');
    Route::get("/migration",[StudentController::class, 'migration'])->name('student.migration');
    Route::put('/students/promote', [StudentController::class, 'promoteAll'])->name('students.promote');
    Route::get('/diploma', [DiplomaController::class, 'index'])->name('diploma.index');
    Route::get('/teacher/profile/{id}', [TeacherController::class, 'profile'])->name('teacher.profile');
    Route::get('/assign/subject/{id}', [TeacherController::class, 'assignSubject'])->name('assign.subject');
    Route::post('/store/subject/{id}', [TeacherController::class, 'storeAssignedSubject'])->name('store.assignedsubject');
    Route::delete('/delete/teacher/{id}',[TeacherController::class, 'deleteTeacher'])->name('teacher.delete');
    Route::get('/diploma/form', [DiplomaController::class, 'diplomaForm'])->name('diploma.form');
    Route::post('/store/diploma', [DiplomaController::class, 'storeDiplomaForm'])->name('store.diploma');
    Route::get('/edit/diploma/{id}', [DiplomaController::class, 'editDiploma'])->name('edit.diploma');
    Route::get('/search/index', [DiplomaController::class, 'index'])->name('diploma.searchindex');
    Route::get('/get/diplomas/{id}',[DiplomaController::class,'getProfessional']);
    Route::get('/get/academic/{id}', [DiplomaController::class, 'getAcademic']);
    Route::put('/update/student/{id}', [StudentController::class, 'updateStudent'])->name('update.student');


    // Route::post('/student/create',[StudentController2::class, 'store'])->name('student.create.new');
    // Route::post('/student/create/bro', [StudentController::class, 'store'])->name('student.save');
    Route::resource('assignrole', 'RoleAssign');
    Route::resource('classes', 'GradeController');
    Route::resource('subject', 'SubjectController');
    Route::resource('teacher', 'TeacherController');
    Route::resource('parents', 'ParentsController');
    Route::resource('student', 'StudentController');
    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');

});

Route::group(['middleware' => ['auth','role:Teacher']], function () 
{
    Route::post('attendance', 'AttendanceController@store')->name('teacher.attendance.store');
    Route::get('attendance-create/{classid}', 'AttendanceController@createByTeacher')->name('teacher.attendance.create');
});

Route::group(['middleware' => ['auth','role:Parent']], function () 
{
    Route::get('attendance/{attendance}', 'AttendanceController@show')->name('attendance.show');
});

Route::group(['middleware' => ['auth','role:Student']], function () {
    Route::get('/studentbooks', [BookController::class, 'displayBooks'])->name('student.books');
    Route::get('/fees', [StudentController::class,'studentSchoolFees'])->name('see.fees');    // Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');

    Route::get('/history',[FeesController::class, 'feesHistory'])->name('fees.history');
    Route::post("/gethistory", [FeesController::class, 'getFeeHistory'])->name('get.history');
    Route::post('/query/books', [BookController::class,'searchBooks'])->name('query.books');
});

Route::get('/test4',[ParentsController::class,'index']);
Route::get('/test22', [StudentController::class, 'all']);
// Route::get('/fees/get-student-name', [FeesController::class, 'getStudentName']);
// Route::post('/search/student', [StudentController::class, 'searchStudent']);

// SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for type bigint: "librarybooks" CONTEXT: unnamed portal parameter $1 = '...' (SQL: select * from "students" where "id" = librarybooks limit 1)
