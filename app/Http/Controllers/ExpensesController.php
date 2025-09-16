<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use App\Expenses;
use App\Canteen;
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
                "source_of_expense" => 'nullable|string',
                "description" => 'required|string|max:300',
                'expense_category' => 'required|string',
                "currency" => "required|string|in:Ghana Cedi,Dollar",
                "mode_of_payment" => 'required|string',
                'cheque_number' => 'nullable|string',
                "amount" => "required|string",
                "cash_amount_details" => "nullable|string",
                "mobile_money_details" => "nullable|string",
                "bank_details" => 'nullable|string'
            ]);

            Expenses::create([
                'source_of_expense'=> $validatedData['source_of_expense'] ?? null,
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
        } catch (Exception $e) {
            Log::error('Error creating student: ' . $e);

            return redirect()->back()->with('error', 'Error creating expense');
        }
    }

    public function getExpensesReportsForm() {
        $categorys = ExpenseCategory::all();

        return view('backend.reports.expensesreportform', compact('categorys'));
    }
    
    // public function indexTable(Request $request) 
    //     {
    //         $search = $request->input('search');
    //         $query = Expenses::with('expenseCategory');
           

    //         if($request->has('search') && $request->search != '') {
    //             $search = $request->search;
    //             $query->where(function($q) use ($search) {
    //                 $q->where('amount', 'like', '%' . $search . '%')
    //                     ->orWhere('category', 'like', '%' . $search . '%')
    //                 ->orWhere('mode_of_payment', 'like', '%' . $search . '%');
    //             });
    //         }

    //         $expenses = $query->latest()->paginate(10);

    //         return view('backend.expenses.index', compact('expenses'));
    // }

    public function indexTable(Request $request) 
    {
        $search = $request->input('search');
        $query = Expenses::with('expenseCategory');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('amount', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%')
                ->orWhere('mode_of_payment', 'like', '%' . $search . '%')
                // Search by related expense category name
                ->orWhereHas('expenseCategory', function($catQuery) use ($search) {
                    $catQuery->where('expense_category', 'like', '%' . $search . '%');
                });
            });
        }

        $expenses = $query->latest()->paginate(10);

        return view('backend.expenses.index', compact('expenses'));
    }

    public function generateExpensesReport(Request $request)
{
    try {
        // dd($request->all());
        $validatedData = $request->validate([
            'current_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'mode_of_payment' => 'nullable|string|in:Cash,Mobile Money,Bank Transfer,Cheque',
            'expense_category' => 'nullable',
            'branch' => 'nullable|in:Kasoa,Kanda,Spintex'
        ]);

        $filters = [
            'currentDate' => $validatedData['current_date'] ?? null,
            'startDate' => $validatedData['start_date'] ?? null,
            'endDate' => $validatedData['end_date'] ?? null,
            'branch' => $validatedData['branch'] ?? null,
            'category' => $validatedData['expense_category'] ?? null,
            'modeOfPayment' => $validatedData['mode_of_payment'] ?? null,
        ];

        // Build dynamic query based on filters
        // $buildQuery = function ($categoryId = null) use ($filters) {
        $query = Expenses::query();

        if ($filters['startDate'] && $filters['endDate']) {
            $query->whereBetween('created_at', [
                Carbon::parse($filters['startDate'])->startOfDay(),
                Carbon::parse($filters['endDate'])->endOfDay()
            ]);
        }

        if ($filters['currentDate']) {
            $query->whereDate('created_at', Carbon::parse($filters['currentDate']));
        }

        if ($filters['category']) {
            $query->where('category', $filters['category']);
        }

        if ($filters['modeOfPayment']) {
            $query->where('mode_of_payment', $filters['modeOfPayment']);
        }

        if($filters['branch']) {
            $query->where('branch',$filters['branch']);
        }

        $datas = $query->get();

        // return $datas;

        $totalAmount = collect($datas)->sum(function ($item) {
            return (float) $item['amount'];
        });

        return view('backend.reports.expensesreport',compact('datas','totalAmount','filters'));
    
    } catch (Exception $e) {
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

            $sourseOfExpense = $validatedData['source_of_expense'] ?? null;
            $description = $validatedData['description'] ?? null;
            $category = $validatedData['category'] ?? null;
            $currency = $validatedData['currency'] ?? null; 
            $amount = $validatedData['amount'] ?? null;
            $modeOfPayment = $validatedData['mode_of_payment'] ?? null;
            $chequeNumber = $validatedData['cheque_number'] ?? null;
            $cashAmountDetails = $validatedData['cash_amount_details'] ?? null;
            $mobileMoneyDetails = $validatedData['mobile_money_details'] ?? null;
            $bankDetails = $validatedData['bank_details'] ?? null;
    
            $expense = Expenses::findOrFail($id);
    
            $updated = $expense->update([
                'source_of_expense' => $sourseOfExpense,
                'description_of_expense' => $description,
                'category' => $category,
                'currency' => $currency,
                'amount' => $amount,
                'mode_of_payment' => $modeOfPayment,
                'cheque_number' => $chequeNumber,
                'cash_details' => $cashAmountDetails,
                'mobile_money_details' => $mobileMoneyDetails,
                'bank_details' => $bankDetails
            ]); 

            if($updated === true) {
                return redirect()->back()->with('success', 'Updated successfully');
            }
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error updating expense: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error updating expense');
        }
    }

    public function viewExpensesCategory() {
        $categories = ExpenseCategory::latest()->paginate(10);

        return view('backend.expenses.expensecategory', compact('categories'));
    }

    public function deleteExpenseCategory($id) {
        $category = ExpenseCategory::findOrFail($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Expense category not found.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Expense category deleted successfully.');
    }

    public function editExpenseCategoryForm($id) {
        $category = ExpenseCategory::findOrFail($id);

        return view('backend.expenses.editexpensecategory', compact('category'));
    }

    public function updateExpenseCategory(Request $request, $id) {
        try {
            //code...
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
            ]);

            $name = $validatedData['name'];
    
            $category = ExpenseCategory::findOrFail($id);
    
            $updated = $category->update([
                'expense_category' => $name,
            ]); 

            if($updated === true) {
                return redirect()->back()->with('success', 'Updated successfully');
            }
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error updating expense category: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error updating expense category');
        }
    }

    public function createExpenseCategoryForm() {
        return view('backend.expenses.createexpensecategory');
    }

    public function createExpenseCategory(Request $request) {
        try {
            // dd($request->all());
            $validatedData = $request->validate([
                'expense_category' => 'required|string|max:100|unique:expense_category,expense_category',
            ]);

            $name = $validatedData['expense_category'];
    
            ExpenseCategory::create([
                'expense_category' => $name,
            ]); 

            return redirect()->back()->with('success', 'Expense category created successfully');
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error creating expense category: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error creating expense category');
        }
    }

    public function canteenIndex(Request $request) {
        $query = Canteen::query();

        if($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('mode_of_transaction', 'like', '%' . $search . '%')
                    ->orWhere('branch', 'like', '%' . $search . '%');
            });
        }

        if($request->has('sort') && $request->sort != '') {
           $query->where('category', $request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $canteenItems = $query->latest()->paginate(10);

        return view('backend.canteen.index', compact('canteenItems'));
    }

    public function createCanteenItemForm() {
        return view('backend.canteen.create');
    }
}
