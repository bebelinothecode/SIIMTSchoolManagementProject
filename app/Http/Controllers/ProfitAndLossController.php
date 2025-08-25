<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use App\Expenses;
use App\FeesPaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfitAndLossController extends Controller
{
    public function index() {
        return view('backend.accountandfinance.profitandloss');
    }

    // public function generateProfitAndLossReport(Request $request) {
    //     $validatedData = $request->validate([
    //         'current_date' => 'nullable|date',
    //         'start_date' => 'nullable|date',
    //         'end_date' => 'nullable|date|after_or_equal:start_date',
    //         'branch' => 'required|in:Kanda,Kasoa,Spintex',
    //     ]);

    //     $currentDate = $validatedData['current_date'];
    //     $startDate = $validatedData['start_date'];
    //     $endDate = $validatedData['end_date'];
    //     $branch = $validatedData['branch'];

    //     $expenseCategory = ExpenseCategory::all();

    //     $grades = DB::table('grades')->get();

    //     $queryIncome = FeesPaid::query();

    //     $queryExpense = Expenses::query();


    //     // ===========Income Query===========

    //    $incomes = $queryIncome->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
    //         ->join('grades', DB::raw("
    //             CASE 
    //                 WHEN students.student_category = 'Academic' THEN students.course_id
    //                 ELSE students.course_id_prof
    //             END
    //         "), '=', 'grades.id')
    //         ->where('students.branch', $branch)
    //         ->when($request->filled('current_date'), function ($query) use ($request) {
    //             // Filter by one specific date
    //             $currentDate = \Carbon\Carbon::parse($request->input('current_date'));
    //             $query->whereDate('collect_fees.created_at', $currentDate);
    //         })
    //         ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
    //         })
    //         ->select('grades.id', 'grades.course_name', DB::raw('SUM(collect_fees.amount) as total_income'))
    //         ->groupBy('grades.id', 'grades.course_name')
    //         ->get();

    //     // return $incomes;

        
    //     $incomeTransactions = DB::table('collect_fees')
    //         ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
    //         ->join('grades', DB::raw("
    //             CASE 
    //                 WHEN students.student_category = 'Academic' THEN students.course_id
    //                 ELSE students.course_id_prof
    //             END
    //         "), '=', 'grades.id')
    //         ->where('students.branch', $branch)
    //         ->when($currentDate, function ($query) use ($currentDate) {
    //             $query->whereDate('collect_fees.created_at', \Carbon\Carbon::parse($currentDate));
    //         })
    //         ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
    //         })
    //         ->select(
    //             'grades.id as grade_id',
    //             'collect_fees.id',
    //             'collect_fees.student_index_number',
    //             'collect_fees.amount',
    //             'students.branch',
    //             'collect_fees.created_at'
    //         )
    //         ->get()
    //         ->groupBy('grade_id');

    //     // return $incomeTransactions;

    //   $incomesProf = $queryIncome
    //         ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
    //         ->join('diploma', function ($join) {
    //             $join->on(DB::raw("
    //                 CASE 
    //                     WHEN students.student_category = 'Professional' THEN students.course_id_prof
    //                     ELSE students.course_id
    //                 END
    //             "), '=', 'diploma.id');
    //         })
    //         ->where('students.branch', $branch)
    //         ->when($request->filled('current_date'), function ($query) use ($request) {
    //             $currentDate = \Carbon\Carbon::parse($request->input('current_date'));
    //             $query->whereDate('collect_fees.created_at', $currentDate);
    //         })
    //         ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
    //         })
    //         ->select('diploma.id', 'diploma.name', DB::raw('SUM(collect_fees.amount) as total_income'))
    //         ->groupBy('diploma.id', 'diploma.name')
    //         ->get();


    //     return $incomesProf;

        
    //     $incomeProfTransactions = DB::table('collect_fees')
    //         ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
    //         ->join('diploma', DB::raw("
    //             CASE 
    //                 WHEN students.student_category = 'Professional' THEN students.course_id_prof
    //                 ELSE students.course_id
    //             END
    //         "), '=', 'diploma.id')
    //         ->where('students.branch', $branch)
    //         ->when($currentDate, function ($query) use ($currentDate) {
    //             $query->whereDate('collect_fees.created_at', \Carbon\Carbon::parse($currentDate));
    //         })
    //         ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
    //         })
    //         ->select(
    //             'diploma.id as diploma_id',
    //             'collect_fees.id',
    //             'collect_fees.student_index_number',
    //             'collect_fees.amount',
    //             'students.branch',
    //             'collect_fees.created_at'
    //         )
    //         ->get()
    //         ->groupBy('diploma_id');
        
    //     return $incomeProfTransactions;

    //     // ===========Expense Query===========
    //     $expenses = DB::table('expenses')
    //         ->join('expense_category', 'expenses.category', '=', 'expense_category.expense_category')
    //         ->select(
    //             'expense_category.id',
    //             'expense_category.expense_category',
    //             DB::raw('SUM(expenses.amount) as total_expense')
    //         )
    //         ->whereBetween('expenses.created_at', [$startDate, $endDate]) // ✅ qualified
    //         ->where('expenses.branch', '=', 'Kanda')
    //         ->groupBy('expense_category.id', 'expense_category.expense_category')
    //         ->get();

    //     $expenseTransactions = DB::table('expenses')
    //         ->join('expense_category', 'expenses.category', '=', 'expense_category.expense_category')
    //         ->select(
    //             'expense_category.id as category_id',
    //             'expenses.id',
    //             'expenses.description_of_expense',
    //             'expenses.amount',
    //             'expenses.branch',
    //             'expenses.created_at' // ✅ avoid ambiguity
    //         )
    //         ->whereBetween('expenses.created_at', [$startDate, $endDate])
    //         ->where('expenses.branch', '=', 'Kanda')
    //         ->get()
    //         ->groupBy('category_id');



    //     // ===Form Fees ===
    //     $formFees = DB::table('student_enquires')
    //         ->where('bought_forms','=','Yes')
    //         // ->where('branch', $branch)
    //         ->when($currentDate, function ($query) use ($currentDate) {
    //             $query->whereDate('created_at', \Carbon\Carbon::parse($currentDate));
    //         })
    //         ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('created_at', [$startDate, $endDate]);
    //         })
    //         ->get();


    //     // ======Maturre Students Fees ======
    //     $matureStudentsFees = DB::table('mature_students')
    //         // ->where('branch', $branch)
    //         ->when($currentDate, function ($query) use ($currentDate) {
    //             $query->whereDate('created_at', \Carbon\Carbon::parse($currentDate));
    //         })
    //         ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
    //             $query->whereBetween('created_at', [$startDate, $endDate]);
    //         })
    //         ->get();

    // $totalIncome   = $incomes->sum('total_income');
    // $totalExpenses = $expenses->sum('total_expense');
    // $profit        = $totalIncome - $totalExpenses;


    // return view('backend.accountandfinance.profitandlossreport', compact('profit','totalExpenses','totalIncome','branch','startDate','endDate','incomes', 'incomeTransactions', 'expenses', 'expenseTransactions', 'formFees', 'matureStudentsFees', 'expenseCategory', 'grades'));
    // }
    
    public function generateProfitAndLossReport(Request $request)
{
    $validatedData = $request->validate([
        'current_date' => 'nullable|date',
        'start_date'   => 'nullable|date',
        'end_date'     => 'nullable|date|after_or_equal:start_date',
        'branch'       => 'required|in:Kanda,Kasoa,Spintex',
    ]);

    $currentDate = $validatedData['current_date'] ?? null;
    $startDate   = $validatedData['start_date'] ?? null;
    $endDate     = $validatedData['end_date'] ?? null;
    $branch      = $validatedData['branch'];

    $expenseCategory = ExpenseCategory::all();
    $grades = DB::table('grades')->get();

    $queryIncome  = FeesPaid::query();
    $queryExpense = Expenses::query();


    // =========== Income Query (Grades) ===========
    $incomes = $queryIncome
        ->join('students as s', 'collect_fees.student_index_number', '=', 's.index_number')
        ->join('grades as g', function ($join) {
            $join->on(DB::raw("
                CASE 
                    WHEN s.student_category = 'Academic' THEN s.course_id
                    ELSE s.course_id_prof
                END
            "), '=', 'g.id');
        })
        ->where('s.branch', $branch)
        ->when($currentDate, function ($query) use ($currentDate) {
            $query->whereDate('collect_fees.created_at', \Carbon\Carbon::parse($currentDate));
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
        })
        ->select(
            'g.id',
            'g.course_name',
            DB::raw('SUM(collect_fees.amount) as total_income')
        )
        ->groupBy('g.id', 'g.course_name')
        ->get();

        // return $incomes;


    // =========== Income Transactions (Grades) ===========
    $incomeTransactions = DB::table('collect_fees as cf')
        ->join('students as st', 'cf.student_index_number', '=', 'st.index_number')
        ->join('grades as g', function ($join) {
            $join->on(DB::raw("
                CASE 
                    WHEN st.student_category = 'Academic' THEN st.course_id
                    ELSE st.course_id_prof
                END
            "), '=', 'g.id');
        })
        ->where('st.branch', $branch)
        ->when($currentDate, function ($query) use ($currentDate) {
            $query->whereDate('cf.created_at', \Carbon\Carbon::parse($currentDate));
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('cf.created_at', [$startDate, $endDate]);
        })
        ->select(
            'g.id as grade_id',
            'cf.id',
            'cf.student_index_number',
            'cf.amount',
            'st.branch',
            'cf.created_at'
        )
        ->get()
        ->groupBy('grade_id');


    // =========== Income Query (Diploma) ===========
    $incomesProfs = $queryIncome
        ->join('students as stt', 'collect_fees.student_index_number', '=', 'stt.index_number')
        ->join('diploma as d', function ($join) {
            $join->on(DB::raw("
                CASE 
                    WHEN stt.student_category = 'Professional' THEN stt.course_id_prof
                    ELSE stt.course_id
                END
            "), '=', 'd.id');
        })
        ->where('stt.branch', $branch)
        ->when($currentDate, function ($query) use ($currentDate) {
            $query->whereDate('collect_fees.created_at', \Carbon\Carbon::parse($currentDate));
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
        })
        ->select(
            'd.id',
            'd.name',
            DB::raw('SUM(collect_fees.amount) as total_income')
        )
        ->groupBy('d.id', 'd.name')
        ->get();

        // return $incomesProfs;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      

    // =========== Income Transactions (Diploma) ===========
    $incomeProfTransactions = DB::table('collect_fees as cf')
        ->join('students as sttt', 'cf.student_index_number', '=', 'sttt.index_number')
        ->join('diploma as d', function ($join) {
            $join->on(DB::raw("
                CASE 
                    WHEN sttt.student_category = 'Professional' THEN sttt.course_id_prof
                    ELSE sttt.course_id
                END
            "), '=', 'd.id');
        })
        ->where('sttt.branch', $branch)
        ->when($currentDate, function ($query) use ($currentDate) {
            $query->whereDate('cf.created_at', \Carbon\Carbon::parse($currentDate));
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('cf.created_at', [$startDate, $endDate]);
        })
        ->select(
            'd.id as diploma_id',
            'cf.id',
            'cf.student_index_number',
            'cf.amount',
            'sttt.branch',
            'cf.created_at'
        )
        ->get()
        ->groupBy('diploma_id');


    // =========== Expense Query ===========
    $expenses = DB::table('expenses as e')
        ->join('expense_category as ec', 'e.category', '=', 'ec.expense_category')
        ->select(
            'ec.id',
            'ec.expense_category',
            DB::raw('SUM(e.amount) as total_expense')
        )
        ->whereBetween('e.created_at', [$startDate, $endDate])
        ->where('e.branch', '=', $branch)
        ->groupBy('ec.id', 'ec.expense_category')
        ->get();

    $expenseTransactions = DB::table('expenses as e')
        ->join('expense_category as ec', 'e.category', '=', 'ec.expense_category')
        ->select(
            'ec.id as category_id',
            'e.id',
            'e.description_of_expense',
            'e.amount',
            'e.branch',
            'e.created_at'
        )
        ->whereBetween('e.created_at', [$startDate, $endDate])
        ->where('e.branch', '=', $branch)
        ->get()
        ->groupBy('category_id');


    // =========== Form Fees ===========
    $formFees = DB::table('student_enquires')
        ->where('bought_forms', '=', 'Yes')
        ->when($currentDate, function ($query) use ($currentDate) {
            $query->whereDate('created_at', \Carbon\Carbon::parse($currentDate));
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->get();


    // =========== Mature Students Fees ===========
    $matureStudentsFees = DB::table('mature_students')
        ->when($currentDate, function ($query) use ($currentDate) {
            $query->whereDate('created_at', \Carbon\Carbon::parse($currentDate));
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->get();


    // Totals
    $totalIncome   = $incomes->sum('total_income') + $incomesProfs->sum('total_income');
    $totalExpenses = $expenses->sum('total_expense');
    $profit        = $totalIncome - $totalExpenses;

    return view('backend.accountandfinance.profitandlossreport', compact(
        'profit',
        'totalExpenses',
        'totalIncome',
        'branch',
        'incomesProfs',
        'startDate',
        'endDate',
        'incomes',
        'incomeTransactions',
        'incomeProfTransactions',
        'expenses',
        'expenseTransactions',
        'formFees',
        'matureStudentsFees',
        'expenseCategory',
        'grades',
        'currentDate'
    ));
}

}
