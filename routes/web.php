<?php

use App\FeesPaid;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CollectionsController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ProfitAndLossController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\LecturerEvaluationController;
use App\Http\Controllers\InventoryController;
use App\Student;
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

Route::group(['middleware' => ['auth','role:Admin|rector|frontdesk|AsstAccount|Student|StudCoordinator|Librarian|HR|registrar|Supervisor']], function () 
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
    Route::get('/assign-subject-to-class/{id}', 'GradeController@assignSubject')->name('class.assign.subject');
    Route::post('/assign-subject-to-class/{id}', 'GradeController@storeAssignedSubject')->name('store.class.assign.subject');
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
    Route::post('/save/subjects/to/course/{id}', [SubjectController::class,'assignSubjectsToCourse'])->name('save.assignedsubjecttocourse');
    Route::delete('/delete/teacher/{id}',[TeacherController::class, 'deleteTeacher'])->name('teacher.delete');
    Route::get('/diploma/form', [DiplomaController::class, 'diplomaForm'])->name('diploma.form');
    Route::post('/store/diploma', [DiplomaController::class, 'storeDiplomaForm'])->name('store.diploma');
    Route::get('/edit/diploma/{id}', [DiplomaController::class, 'editDiplomaForm'])->name('edit.diploma');
    Route::post('/update/diploma/{id}', [DiplomaController::class, 'updateDiploma'])->name('update.diploma');
    Route::get('/search/index', [DiplomaController::class, 'index'])->name('diploma.searchindex');
    Route::get('/get/diplomas/{id}',[DiplomaController::class,'getProfessional']);
    Route::get('/get/academic/{id}', [DiplomaController::class, 'getAcademic']);
    Route::put('/update/student/{id}', [StudentController::class, 'updateStudent'])->name('update.student');
    Route::get('/get/transactions', [FeesController::class, 'getTransactions'])->name('get.transactions');
    Route::get('/reports/form',[ReportsController::class, 'getReportsForm'])->name('reports.form');
    Route::get('/reports/form/academic',[ReportsController::class, 'getAcademicReportsForm'])->name('academic.reportsform');
    Route::get('/report/academmic',[ReportsController::class, 'generateAcademicReport'])->name('getacademic.reports');
    Route::get('/teacher/form', [ReportsController::class, 'teachersForm'])->name('teacherreport.form');
    Route::get('/reports/generate', [ReportsController::class, 'generate'])->name('reports.generate');
    Route::get('/report/teacher',[ReportsController::class,'generateForm'])->name('teacher.report');
    Route::get('payments/report/form', [ReportsController::class,'getPaymentReportForm'])->name('payments.form');
    Route::get('/payment/report', [ReportsController::class, 'generatePaymentReport'])->name('payment.report');
    Route::get('/delete/assigned/subject/{id}',[SubjectController::class,'getDeleteForm'])->name('deleteassigned.subject');
    Route::delete('/delete/assigned/subject/{id}',[SubjectController::class,'deleteAssignedSubject'])->name('delete.assigned');
    Route::delete('/delete/diploma/{id}',[DiplomaController::class,'deleteDiploma'])->name('delete.diploma');
    Route::get('/get/course/overview/form/{id}',[StudentController::class, 'courseOverviewForm'])->name('course.overviewform');
    Route::get("/enquiries/index", [StudentController::class, 'index22'])->name("enquiries.index");
    Route::get('/expenses',[ExpensesController::class, 'getExpensesForm'])->name('get.expensesForm');
    Route::post('/save/expense',[ExpensesController::class, 'storeExpenses'])->name('save.expense');
    Route::get('/expenses/table', [ExpensesController::class, 'indexTable'])->name('expenses.table');
    Route::get('/expenses/reports/form',[ExpensesController::class, 'getExpensesReportsForm'])->name('form.expenses');
    Route::get('/get/expenses/report', [ExpensesController::class, 'generateExpensesReport'])->name('generate.expensesreport');
    Route::get('/get/collections/academic',[CollectionsController::class, 'getAcademicCollectionsForm'])->name('collections.academicform');
    Route::get('/get/collections/professional',[CollectionsController::class, 'getProfessionalCollectionsForm'])->name('collections.professionalform');
    Route::get('/get/balance/form', [ReportsController::class, 'getBalanceForm'])->name('get.balanceform');
    Route::post('/calculate/balance', [ReportsController::class, 'calculateBalanceTotal'])->name('calculate.balance');
    Route::get('/pay/fees/{id}',[StudentController::class, 'payStudentFeesForm'])->name('pay.feesform');
    Route::get('/get/assign/form/{id}', [SubjectController::class, 'getAssignSubjectsToCourseForm'])->name('get.assignmentform');
    Route::post('/get/course/overview/report/{id}', [StudentController::class, 'courseOverviewReport'])->name('courseoverview.report');
    Route::get('/students/import', [StudentController::class, 'showImportForm'])->name('students.import.form');
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/document/request/form',[StudentController::class, 'getDocumentRequestForm'])->name('document.request');
    Route::post('/submit/document/request', [StudentController::class, 'submitDocumentForm'])->name('submit.documentform');
    Route::get('/edit/transaction/form/{id}',[FeesController::class, 'editTransactionForm'])->name('edit.transactionform');
    Route::put('/edit/transaction/{id}',[FeesController::class, 'updateTransaction'])->name('edit.transaction');
    Route::delete('/delete/transaction/{id}',[FeesController::class, 'deleteTransaction'])->name('delete.transaction');
    Route::get('/show/courseoutline/form',[StudentController::class,'getCourseOutlineForm'])->name('show.course');
    Route::get('/get/change/students/status/form/{id}',[StudentController::class, 'getChangeStudentsStatusForm'])->name('change.studentstatusform');
    Route::post('/change/student/status/{id}',[StudentController::class,'changeStudentsStatus'])->name('change.studentstatus');
    Route::get('/get/defer/list/form',[StudentController::class,'getDeferListForm'])->name('get.deferlistform');
    Route::get('/get/defer/list',[StudentController::class,'getDeferList'])->name('get.deferlist');
    Route::get('/get/defaulters/list/form',[StudentController::class,'getDefaultersReportForm'])->name('get.defaultersreportform');
    Route::get('/restore/defer/students/{id}',[StudentController::class,'restoreDeferStudents'])->name('restore.deferstudents');
    Route::get('/get/defaulters',[StudentController::class,'getDefaulterList'])->name('get.defaulters');
    Route::get('/get/deleted/students',[StudentController::class,'retrieveSoftDeletedStudents'])->name('get.deletedstudents');
    Route::get('/restore/deleted/student/{id}',[StudentController::class, 'restoreDeletedStudent'])->name('restore.deletedstudent');
    Route::delete('/delete/expense/{id}',[ExpensesController::class, 'deleteExpense'])->name('expense.destroy');
    Route::get('/edit/expenses/form/{id}',[ExpensesController::class, 'editExpense'])->name('expense.edit');
    Route::post('/expense/update/{id}',[ExpensesController::class, 'updateExpense'])->name('expense.update');
    Route::get('/all/books',[BookController::class, 'showAllBooks'])->name('books.index');
    Route::get('/mature/students',[StudentController::class, 'matureStudentsIndex'])->name('mature.index');
    Route::get('/create/mature/student/form',[StudentController::class, 'createMatureStudentForm'])->name('create.maturestudent');
    Route::post('/store/mature/student',[StudentController::class, 'storeMatureStudent'])->name('store.maturestudent');
    Route::delete('/delete/mature/student/{id}',[StudentController::class, 'deleteMatureStudent'])->name('delete.maturestudent');
    Route::get('/edit/mature/student/{id}',[StudentController::class, 'editMatureStudentForm'])->name('edit.maturestudentform');
    Route::put('/edit/mature/student/{id}',[StudentController::class,'editMatureStudent'])->name('edit.maturestudent');
    Route::get('/move/maturestudent/student/form/{id}',[StudentController::class,'moveMatureStudentToStudentForm'])->name('movemature.studentform');
    Route::post('maturestudent/student/{id}',[StudentController::class,'moveMatureStudentToStudent'])->name('movemature.tostudent');
    Route::delete('/delete/book/{id}',[BookController::class, 'deleteLibraryBook'])->name('books.delete');
    Route::delete('/delete/pastquestion/{id}',[BookController::class, 'deletePastQuestion'])->name('pastquestions.delete');
    Route::get('/profit/and/loss',[ProfitAndLossController::class, 'index'])->name('profit.andloss');
    Route::post('/generate/profit/and/loss',[ProfitAndLossController::class,'generateProfitAndLossReport'])->name('generate.profitandloss');
    Route::get("/print/receipts/from/transactions/{id}",[FeesController::class, 'printReceiptFromTransaction'])->name('print.transactionreceipt');
    Route::delete('/delete/enquiry/{id}',[StudentController::class, 'deleteEnquiry'])->name('delete.enquiry');
    Route::get('/print/enquiry/receipt/{id}',[StudentController::class, 'printEnquiryReceipt'])->name('print.enquiryreceipt');
    Route::get('/buy/forms/{id}',[StudentController::class, 'buyFormsLater'])->name('buy.forms');
    Route::get('/create/user/form',[StudentController::class, 'createUsersForm'])->name('create.userform');
    Route::post('/create/user',[StudentController::class, 'createUser'])->name('create.user');
    Route::delete('/delete/mature/transaction/{id}',[StudentController::class, 'deleteMatureTransaction'])->name('delete.maturetransaction');
    Route::get('/mature/student/receipt/{id}',[StudentController::class, 'matureStudentReceipt'])->name('mature.receipt');
    Route::get('evaluate/lecturer/admin/panel',[LecturerEvaluationController::class, 'index'])->name('admin.evaluations.index');
    Route::get('expense/category/index',[ExpensesController::class, 'viewExpensesCategory'])->name('expensecategory.index');
    Route::delete('expense/category/delete/{id}',[ExpensesController::class, 'deleteExpenseCategory'])->name('delete.expensecategory');
    Route::get('expense/category/form/{id}',[ExpensesController::class, 'editExpenseCategoryForm'])->name('edit.expensecategoryform');
    Route::post('expense/category/update/{id}',[ExpensesController::class, 'updateExpenseCategory'])->name('update.expensecategory');
    Route::get('expense/category/create/form',[ExpensesController::class, 'createExpenseCategoryForm'])->name('create.expensecategoryform');
    Route::post('expense/category/create',[ExpensesController::class, 'createExpenseCategory'])->name('create.expensecategory');
    Route::get('students/reports/form',[StudentController::class, 'studentsReportsForm'])->name('students.reportsform');
    Route::post('/generate/students/reports',[StudentController::class, 'generateStudentsReport'])->name('students.report');
    Route::get('/students/report/download', [StudentController::class, 'downloadStudentsReport'])->name('students.report.download');
    Route::get('enquiry/reports/form',[ReportsController::class, 'enquiryReportsForm'])->name('enquiryreport.form');
    Route::post('/generate/enquiry/reports',[ReportsController::class, 'generateEnquiryReport'])->name('enquiry.report');
    Route::get('/canteen/index',[ExpensesController::class, 'canteenIndex'])->name('canteen.index');
    Route::get('/canteen/create/form',[ExpensesController::class, 'createCanteenItemForm'])->name('canteen.createform');
    Route::post('/canteen/store',[ExpensesController::class, 'storeCanteenItem'])->name('canteen.store');
    Route::delete('/canteen/delete/{id}',[ExpensesController::class, 'deleteCanteenItem'])->name('delete.canteenitem');
    Route::get('/canteen/edit/form/{id}',[ExpensesController::class, 'editCanteenItemForm'])->name('edit.canteenItemForm');
    Route::post('/canteen/update/{id}',[ExpensesController::class, 'updateCanteenItem'])->name('update.canteenitem');
    Route::get('/canteen/report/form',[ReportsController::class, 'canteenReportForm'])->name('canteen.reportform');
    Route::post('/generate/canteen/report',[ReportsController::class, 'generateCanteenReport'])->name('canteen.report');
    Route::get('/edit/enquiry/{id}', [DiplomaController::class, 'editEnquiry'])->name('edit.enquiry');
    Route::post('/update/enquiry/{id}', [DiplomaController::class, 'updateEnquiry'])->name('update.enquiry');
    Route::get('/get/paymentplan/form/{id}', [StudentController::class, 'getPaymentPlanForm'])->name('get.paymentplanform');
    Route::post('/save/paymentplan/{id}', [StudentController::class, 'savePaymentPlan'])->name('save.paymentplan');
    Route::put('/update/installments/{id}', [StudentController::class, 'updateInstallments'])->name('update.installments');
    Route::get('/view/inventory', [InventoryController::class, 'index'])->name('view.inventory');
    Route::get('/add/stock/item', [InventoryController::class, 'create'])->name('addstock.form');
    Route::post('/store/stock/item', [InventoryController::class, 'store'])->name('store.stockitem');
    Route::get('/edit/stock/item/{id}', [InventoryController::class, 'edit'])->name('edit.stockitemform');
    Route::put('/update/stock/item/{id}', [InventoryController::class, 'update'])->name('update.stock');
    Route::delete('delete/stock/{id}',[InventoryController::class, 'delete'])->name('delete.stockitem');
    Route::get('/inventory/stockin/form/{id}', [InventoryController::class, 'stockInForm'])->name('stockin.form');
    Route::post('/save/stockin/{id}', [InventoryController::class, 'saveStockIn'])->name('save.stockin');
    Route::get('/inventory/stockout/form/{id}', [InventoryController::class, 'stockOutForm'])->name('stockout.form');
    Route::post('/save/stockout/{id}', [InventoryController::class, 'saveStockOut'])->name('save.stockout');
    Route::get('/inventory/transaction/list/{id}',[InventoryController::class, 'stockTransactionList'])->name('stock.transactionlist');
    Route::get('/generate/stock/purchase/slip',[InventoryController::class, 'generateStockPurchaseSlip'])->name('generate.stockpurchaseslip');
    // Route::get('/inventory/transaction/form/{id}',[InventoryController::class, 'stockTransaction'])->name('stock.transactionform');
    
    Route::resource('assignrole', 'RoleAssign');
    Route::resource('classes', 'GradeController');
    Route::resource('subject', 'SubjectController');
    Route::resource('teacher', 'TeacherController');
    Route::resource('parents', 'ParentsController');
    Route::resource('student', 'StudentController');
    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');
});


Route::group(['middleware' => ['auth','role:AsstAccount']], function () {
    // Route::get('/get/transactions', [FeesController::class, 'getTransactions'])->name('get.transactions');
    // Route::get("/collectfees", [FeesController::class, 'showcollectfees'])->name("fees.collect");
    // Route::post('/feescollected',[FeesController::class, 'collectfees'])->name('fees.collected');
    // // Route::get('fees/defaulters', [FeesController::class, 'selectdefaulters'])->name('fees.defaulters');
    // // Route::post('/fees/defaulters', [FeesController::class, 'getdefaulters'])->name('defaulters.show');
    // Route::get('/expenses/table', [ExpensesController::class, 'indexTable'])->name('expenses.table');
    // Route::get('/expenses',[ExpensesController::class, 'getExpensesForm'])->name('get.expensesForm');
    // Route::post('/save/expense',[ExpensesController::class, 'storeExpenses'])->name('save.expense');
    // Route::get('/reports/form',[ReportsController::class, 'getReportsForm'])->name('reports.form');
    // Route::get('/reports/generate', [ReportsController::class, 'generate'])->name('reports.generate');
    // Route::get('/reports/form/academic',[ReportsController::class, 'getAcademicReportsForm'])->name('academic.reportsform');
    // Route::get('/report/academmic',[ReportsController::class, 'generateAcademicReport'])->name('getacademic.reports');
    // Route::get('/teacher/form', [ReportsController::class, 'teachersForm'])->name('teacherreport.form');
    // Route::get('/report/teacher',[ReportsController::class,'generateForm'])->name('teacher.report');
    // Route::get('payements/report/form', [ReportsController::class,'getPaymentReportForm'])->name('payments.form');
    // Route::get('/payment/report', [ReportsController::class, 'generatePaymentReport'])->name('payment.report');
    // // Route::resource('student', 'StudentController');
    // Route::get('/expenses/reports/form',[ExpensesController::class, 'getExpensesReportsForm'])->name('form.expenses');
    // Route::get('/get/expenses/report', [ExpensesController::class, 'generateExpensesReport'])->name('generate.expensesreport');
    // Route::get('/get/balance/form', [ReportsController::class, 'getBalanceForm'])->name('get.balanceform');
    // Route::post('/calculate/balance', [ReportsController::class, 'calculateBalanceTotal'])->name('calculate.balance'); 
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
    // Route::post('/get/course/overview/report/{id}', [StudentController::class, 'courseOverviewReport'])->name('courseoverview.report');
    Route::post("/gethistory", [FeesController::class, 'getFeeHistory'])->name('get.history');
    Route::post('/query/books', [BookController::class,'searchBooks'])->name('query.books');
    // Route::get('/get/courseoutline/form',[StudentController::class,'getCourseOutlineForm'])->name('course.outlineform');
    Route::get('/get/registration/form',[StudentController::class, 'getRegistrationForm'])->name('registration.course');
    Route::post('/register/courses/{id}',[StudentController::class, 'registerCourses'])->name('register.courses');
    Route::get('/show/registered/courses',[StudentController::class, 'showRegisteredCourses'])->name('show.registeredcourses');
    Route::get('/evalaute/lecturers/form',[StudentController::class, 'lecturerEvaluationForm'])->name('evaluate.lecturersform');
    Route::post('/submit/evaluation',[StudentController::class, 'evaluateLecturer'])->name('submit.evaluation');
    // Route::get('/school/fees',[FeesController::class, 'schoolFees'])->name('schoolfees.index');                 
});

// Route::group(['middleware' => ['auth','role:frontdesk']], function () {
//     // Route::resource('classes', 'GradeController');
//     // Route::resource('subject', 'SubjectController');
//     // Route::get('/diploma', [DiplomaController::class, 'index'])->name('diploma.index');

// });

// Route::get('/test4',[ReportsController::class,'example']);
// Route::get('/test22', [StudentController::class, 'all']);

