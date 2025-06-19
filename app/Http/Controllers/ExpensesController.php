<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use App\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class ExpensesController extends Controller
{
    public function getExpensesForm() {
        $categories = ExpenseCategory::all();

        return view('backend.expenses.expensesForm', compact('categories'));
    }

    public function storeExpenses(Request $request) {
        try {
            // dd($request->all());
            $validatedData = $request->validate([
                "source_of_expense" => 'required|string',
                "description" => 'required|string|max:300',
                "expense_category" => 'required|string',
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
                'category' => $validatedData['expense_category'],
                'currency' => $validatedData['currency'],
                'amount' => $validatedData['amount'],
                'mode_of_payment' => $validatedData['mode_of_payment'],
                'mobile_money_details' => $validatedData['mobile_money_details'],
                'cash_details' => $validatedData['cash_amount_details'],
                'bank_details' => $validatedData['bank_details'],
                // 'cash_details' => $validatedData['cash_amount_details']
                ]);

            return redirect()->back()->with('success', 'Expense created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating student: ' . $e);

            return redirect()->back()->with('error', 'Error creating expense');
        }
    }

    public function getExpensesReportsForm() {
        $categorys = ExpenseCategory::all();

        return view('backend.reports.expensesreportform', compact('categorys'));
    }
    
    public function indexTable(Request $request) 
        {
            $query = Expenses::query();

            if($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('amount', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('mode_of_payment', 'like', '%' . $search . '%');
                });
            }

            $expenses = $query->latest()->paginate(10);

            return view('backend.expenses.index', compact('expenses'));
        }

    public function generateExpensesReport(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'current_date' => 'nullable|date',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'mode_of_payment' => 'nullable|string|in:Cash,Mobile Money,Bank Transfer,Cheque',
                'student_category' => 'nullable|string|in:Academic,Professional',
            ]);
            
            // Extract filters
            $filters = [
                'currentDate' => $validatedData['current_date'] ?? null,
                'startDate' => $validatedData['start_date'] ?? null,
                'endDate' => $validatedData['end_date'] ?? null,
                'studentCategory' => $validatedData['student_category'] ?? null,
                'modeOfPayment' => $validatedData['mode_of_payment'] ?? null,
            ];
            
            // Base query function
            $buildQuery = function($category = null) use ($filters) {
                $query = Expenses::query();

                // Date range filter
                if ($filters['startDate'] && $filters['endDate']) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($filters['startDate'])->startOfDay(),
                        Carbon::parse($filters['endDate'])->endOfDay()
                    ]);
                }

                // Current date filter
                if ($filters['currentDate']) {
                    $query->whereDate('created_at', Carbon::parse($filters['currentDate']));
                }

                // Student category filter
                if ($category) {
                    $query->where('source_of_expense', $category);
                } elseif ($filters['studentCategory']) {
                    $query->where('source_of_expense', $filters['studentCategory']);
                }

                // Mode of payment filter
                if ($filters['modeOfPayment']) {
                    $query->where('mode_of_payment', $filters['modeOfPayment']);
                }

                return $query;
            };

            // Get data based on student category selection
            if ($filters['studentCategory']) {
                // Single category selected
                $expenses = $buildQuery()->get();
                $categories = [$filters['studentCategory'] => $expenses];
            } else {
                // Both categories
                $categories = [
                    'Academic' => $buildQuery('Academic')->get(),
                    'Professional' => $buildQuery('Professional')->get()
                ];
            }

            // Calculate totals
            $paymentSummaries = [];
            $paymentMethods = ['Cash', 'Mobile Money', 'Bank Transfer', 'Cheque'];
            $totalAmount = 0;

            foreach ($categories as $category => $expenses) {
                $paymentSummaries[$category] = [];
                
                foreach ($paymentMethods as $method) {
                    $filtered = $expenses->where('mode_of_payment', $method);
                    $paymentSummaries[$category][$method] = [
                        'transactions' => $filtered,
                        'total' => $filtered->sum('amount')
                    ];
                }
                
                $totalAmount += $expenses->sum('amount');
            }

            return view('backend.reports.expensesreport', [
                'filters' => $filters,
                'categories' => $categories,
                'paymentSummaries' => $paymentSummaries,
                'totalAmount' => $totalAmount,
                'generatedAt' => now()->format('F j, Y h:i A')
            ]);

        } catch (\Exception $e) {
            Log::error("Error generating expenses report: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error generating expenses report: ' . $e->getMessage());
        }
    }

    public function deleteExpense(Request $request,$id) {
        $expense = Expenses::findOrFail($id);

        if (!$expense) {
            return redirect()->back()->with('error', 'Expense not found.');
        }

        $expense->delete();

        return redirect()->back()->with('success', 'Expense deleted successfully.');
    }

    public function editExpense(Request $request,$id) {
        $expense = Expenses::findOrFail($id);

        $categories = ExpenseCategory::all();

        return view('backend.expenses.edit',compact('expense','categories'));
    }

    public function updateExpense(Request $request, $id) {
        // dd($request->all());
        try {
            //code...
            $validatedData = $request->validate([
                'source_of_expense' => 'nullable|in:Academic,Professional',
                'description' => 'nullable',
                'category' => 'nullable',
                'currency' => 'nullable',
                'amount' => 'nullable',
                'mode_of_payment' => 'nullable',
                'cheque_number' => 'nullable',
                'cash_amount_details' => 'nullable',
                'mobile_money_details' => 'nullable',
                'bank_details' => 'nullable'
            ]);
    
            $expense = Expenses::findOrFail($id);
    
            $expense->update($validatedData); 
    
            return redirect()->back()->with('success', 'Updated successfully');
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error updating student: ' . $e);

            return redirect()->back()->with('error', 'Error updating expense');
        }
    }
}
