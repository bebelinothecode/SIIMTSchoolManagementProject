<?php

namespace App\Http\Controllers;

use App\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExpensesController extends Controller
{
    public function getExpensesForm() {
        return view('backend.expenses.expensesForm');
    }

    public function storeExpenses(Request $request) {
        try {
            $validatedData = $request->validate([
                "source_of_expense" => 'required|string',
                "description" => 'required|string|max:300',
                "category" => 'required|string',
                "currency" => "required|string|in:Ghana Cedi,Dollar",
                "mode_of_payment" => 'required|string',
                'cheque_number' => 'nullable|string',
                "amount" => "required|string",
                "cash_amount_details" => "nullable|string",
                "mobile_money_details" => "nullable|string",
                "bank_details" => 'nullable|string'
            ]);

            Expenses::create([
                'source_of_expense'=> $validatedData['source_of_expense'],
                'description_of_expense' => $validatedData['description'],
                'category' => $validatedData['category'],
                'currency' => $validatedData['currency'],
                'amount' => $validatedData['amount'],
                'mode_of_payment' => $validatedData['mode_of_payment'],
                'mobile_money_details' => $validatedData['mobile_money_details'],
                'cash_details' => $validatedData['cash_amount_details'],
                'bank_details' => $validatedData['bank_details'],
                'cash_details' => $validatedData['cash_amount_details']
            ]);

            return redirect()->back()->with('success', 'Expense created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating student: ' . $e);

            return redirect()->back()->with('error', 'Error creating exxpense');
        }
    }

    public function indexTable() {
        $expenses = Expenses::latest()->paginate(10);

        return view('backend.expenses.index', compact('expenses'));
    }

    public function getExpensesReportsForm() {
        return view('backend.reports.expensesreportform');
    }

    public function generateExpensesReport(Request $request) {
        try {
            $validatedData = $request->validate([
                'current_date' => 'nullable|date',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'category' => 'nullable|string',
            ]);

            $currentDate = $validatedData['current_date'];
            $startDate = $validatedData['start_date'];
            $endDate = $validatedData['end_date'];
            $category = $validatedData['category'];

            $expensesQuery = Expenses::query();

            if ($validatedData['start_date'] && $validatedData['end_date']) {
                $expensesQuery->whereBetween('created_at', [$validatedData['start_date'], $validatedData['end_date']]);
            } elseif ($validatedData['current_date']) {
                $expensesQuery->whereDate('created_at', $validatedData['current_date']);
                }
        
                if ($validatedData['category']) {
                $expensesQuery->where('category', $validatedData['category']);
            }

            $expenses = $expensesQuery->get();

            // return $expenses;

            return view('backend.reports.expensesreport', compact('expenses','category','','startDate','currentDate'));

            // return redirect()->back()->with('success', 'E generating expenses report');    
        } catch (\Exception $e) {
            //throw $th;
            Log::error("Error genrating expenses report".$e->getMessage());

            return redirect()->back()->with('error', 'Error generating expenses report');    
        }
    }
    //
}
