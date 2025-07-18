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

    public function generateProfitAndLossReport(Request $request) {
        // dd($request->all());
        $validatedData = $request->validate([
            'current_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $currentDate = $validatedData['current_date'];
        $startDate = $validatedData['start_date'];
        $endDate = $validatedData['end_date'];

        $expenseCategory = ExpenseCategory::all();

        $queryIncome = FeesPaid::query();

        $queryExpense = Expenses::query();

        $totals = DB::table('expenses')
            ->join('expense_category', 'expenses.category', '=', 'expense_category.expense_ category')
            ->select('expenses.category', DB::raw('SUM(expenses.amount) as total_amount'))
            ->groupBy('expenses.category')
            ->get();
        
        return $totals;

    }
    //
}
