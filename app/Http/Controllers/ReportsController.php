<?php

namespace App\Http\Controllers;

use App\User;
use App\Grade;
use Exception;
use App\Diploma;
use App\Student;
use App\Subject;
use App\Teacher;
use App\FeesPaid;
use App\AcademicYear;
use App\Enquiry;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
    public function getReportsForm(Request $request) {
        $diplomas = Diploma::all();

        return view('backend.reports.students', compact('diplomas'));
    }

    public function example() {
        $admins = User::role('Admin')->get();

        // $student = Student::with(['user','parent','class','attendances'])->findOrFail($user->id); 

        return $admins;
    }

    public function getPaymentReportForm() {
        return view('backend.reports.paymentform');
    }

    public function generate(Request $request) {
        try {
            $validatedData = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'diplomaID' => 'required|integer|exists:diploma,id'
            ]);

            $diplomaID = $validatedData['diplomaID'];
            $end_date = $validatedData['end_date'];
            $start_date = $validatedData['start_date'];
            // dd($request->all());                                                                                                                                                                                                                                    ]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]2)
            // Retrieve parameters from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $diplomaID = $request->input('diplomaID');

        $students = Student::with(['user', 'diploma'])
            ->whereHas('diploma', function ($query) {
                // Ensure the student is associated with a diploma
                $query->whereNotNull('id'); // Assuming 'id' is the primary key of the diplomas table
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                // Filter students created within the date range
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($diplomaID, function ($query, $diplomaID) {
                return $query->whereHas('diploma', function ($q) use ($diplomaID) {
                    $q->where('id', $diplomaID); // Filter by subject ID
                });
            })
            ->get();
        return view('backend.reports.studentreport', compact('students', 'startDate', 'endDate','diplomaID'));
            
        } catch (Exception $e) {
            //throw $th;
        Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
             $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $diplomaID = $request->input('diplomaID');    
            $diploma = Diploma::findOrFail($diplomaID);

            $students = Student::whereNotNull('course_id_prof')
            ->where('course_id_prof', $diplomaID)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->with('user') // Eager load the user relationship
            ->get();
    
            // Pass data to the view
            return view('backend.reports.studentreport', compact('students', 'start_date', 'end_date', 'diploma'));
    
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error in report generation', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'A database error occurred while generating the report.');
        } catch (\Throwable $e) {
            Log::error('Unexpected error in report generation', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }
    
    

    public function teachersForm() {
        $subjects = Subject::all();

        return view('backend.reports.teachersform', compact('subjects'));
    }

    //Teacher's function
    public function generateForm(Request $request) {
        try {
        $level = $request->input('level');
        $semester = $request->input('semester');
        $gender = $request->input('gender');
        $subjectID = $request->input('subjectID');

        $teachers = Teacher::with(['user', 'subjects'])
            ->when($subjectID, function ($query, $subjectID) {
                return $query->whereHas('subjects', function ($q) use ($subjectID) {
                    $q->where('id', $subjectID); // Filter by subject ID
                });
            })
            ->when($level, function ($query, $level) {
                return $query->whereHas('subjects', function ($q) use ($level) {
                    $q->where('level', $level); // Filter by level
                });
            })
            ->when($semester, function ($query, $semester) {
                return $query->whereHas('subjects', function ($q) use ($semester) {
                    $q->where('semester', $semester); // Filter by semester
                });
            })
            ->when($gender, function ($query, $gender) {
                return $query->where('gender', $gender); // Filter by teacher's gender
            })
            ->get();


            // return $teachers;

            return view('backend.reports.teachersreport', compact('teachers','level','semester','gender'));
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function getAcademicReportsForm() {
        $courses = Grade::all();

        $academicyears = AcademicYear::all();

        return view('backend.reports.studentsacademicform', compact('courses','academicyears'));
    }

    public function generateAcademicReport(Request $request) {
        try {
            // dd($request->all());
            $courseID = $request->input('courseID');
            $academicyear = $request->input('academicyear');
            $level = $request->input('level');
            $semester = $request->input('semester');

            $studentsQuery = Student::with('user','course');

            // $course = Grade::findOrFail($courseID);



            $students = Student::with(['user', 'course'])
            ->when($courseID, function ($query, $courseID) {
                return $query->whereHas('course', function ($q) use ($courseID) {
                    $q->where('id', $courseID); // Filter by subject ID
                });
            })
            ->when($level, function ($query, $level) {
                return $query->where('level', $level); // Filter by teacher's gender
            })
            ->when($semester, function ($query, $semester) {
                return $query->where('session', $semester); // Filter by teacher's gender
            })
            ->when($academicyear, function ($query, $academicyear) {
                return $query->where('academicyear', $academicyear); // Filter by teacher's gender
            })
            ->get();

            // return $students;

            return view('backend.reports.studentsacademicreport',compact('courseID','academicyear','level','semester','students'));
        } catch (\Exception $e) {
            //throw $th;
            Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return redirect()->back()->with('error', 'Problem with the query');    
        }
    }

    public function generatePaymentReport(Request $request)
    {
        try {
            // dd($request->all());
            $validatedData = $request->validate([
                'current_date' => 'nullable|date',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'aca_prof' => 'nullable|in:Academic,Professional,All',
                'method_of_payment' => 'nullable|in:Cash,Momo,Cheque'
            ]);

            $currentDate = $validatedData['current_date'] ?? null;
            $startDate = $validatedData['start_date'] ?? null;
            $endDate = $validatedData['end_date'] ?? null;
            $aca_prof = $validatedData['aca_prof'] ?? 'All';
            $methodOfPayment = $validatedData['method_of_payment'];

            // Step 1: Get unique student index numbers from the collect_fees table
            $uniqueIndexNumbers = FeesPaid::distinct()->pluck('student_index_number');

            // Step 2: Fetch student categories for the unique index numbers
            $students = Student::whereIn('index_number', $uniqueIndexNumbers)
                ->pluck('student_category', 'index_number');

            // Step 3: Filter index numbers based on category selection
            $filteredIndexNumbers = $students->filter(function ($category) use ($aca_prof) {
                $categoryLower = strtolower($category);
                $acaProfLower = strtolower($aca_prof);

                return ($acaProfLower === 'all') 
                    ? in_array($categoryLower, ['academic', 'professional'])
                    : ($categoryLower === $acaProfLower);
            })->keys();

            // Step 4: Fetch all fee transactions with filters
            $feeTransactionsQuery = FeesPaid::whereIn('student_index_number', $filteredIndexNumbers);

            // dd($feeTransactionsQuery->get());

            // Apply date filters
            if ($startDate && $endDate) {
                $feeTransactionsQuery->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $feeTransactionsQuery->where('created_at', '>=', $startDate);
            } elseif ($endDate) {
                $feeTransactionsQuery->where('created_at', '<=', $endDate);
            } elseif ($currentDate) {
                $feeTransactionsQuery->whereDate('created_at', $currentDate);
            }

            if($methodOfPayment) {
                $feeTransactionsQuery->where('method_of_payment', $methodOfPayment);
            }

            $feeTransactions = $feeTransactionsQuery->get();

            // Calculate payment method totals
            $method_of_Payment_Total = $feeTransactions->where('method_of_payment', $methodOfPayment)->sum('amount');
            $momoTotal = $feeTransactions->where('method_of_payment', 'Momo')->sum('amount');
            $chequeTotal = $feeTransactions->where('method_of_payment', 'Cheque')->sum('amount');
            $cashTotal = $feeTransactions->where('method_of_payment', 'Cash')->sum('amount');

            // Step 5: Group transactions by student category and currency
            $transactionsByCategoryAndCurrency = [
                'academic' => [],
                'professional' => [],
                'total' => []
            ];

            foreach ($feeTransactions as $transaction) {
                $indexNumber = $transaction->student_index_number;
                $category = strtolower($students[$indexNumber] ?? 'unknown');
                $currency = $transaction->currency;

                if (array_key_exists($category, $transactionsByCategoryAndCurrency)) {
                    if (!isset($transactionsByCategoryAndCurrency[$category][$currency])) {
                        $transactionsByCategoryAndCurrency[$category][$currency] = [];
                    }
                    $transactionsByCategoryAndCurrency[$category][$currency][] = $transaction;
                }
            }

            // Step 6: Calculate totals for each category and currency
            $totalsByCategoryAndCurrency = [
                'academic' => [],
                'professional' => [],
                'total' => []
            ];

            foreach ($transactionsByCategoryAndCurrency as $category => $currencies) {
                foreach ($currencies as $currency => $transactions) {
                    $totalsByCategoryAndCurrency[$category][$currency] = collect($transactions)->sum('amount');
                }
            }

            // dd($totalsByCategoryAndCurrency);

            // Calculate bought forms amount
            $boughtFormsAmount = Enquiry::where('bought_forms', 'Yes')->sum(DB::raw('CAST(amount AS DECIMAL)'));

            return view('backend.reports.paymentreport', [
                'transactionsByCategoryAndCurrency' => $transactionsByCategoryAndCurrency,
                'totalsByCategoryAndCurrency' => $totalsByCategoryAndCurrency,
                'currentDate' => $currentDate,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'aca_prof' => $aca_prof,
                'boughtFormsAmount' => $boughtFormsAmount,
                'method_of_Payment_Total' => $method_of_Payment_Total,
                'methodOfPayment' => $methodOfPayment,
                'cashTotal' => $cashTotal,
                'momoTotal' => $momoTotal,
                'chequeTotal' => $chequeTotal
            ]);

        } catch (Exception $e) {
            Log::error('Error generating payment report', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
        }
    }

    public function getBalanceForm() {
        return view('backend.reports.getbalanceform');
    }

    public function calculateBalance(Request $request) {
        $validatedData = $request->validate([
            'category' => 'nullable|string|in:Academic,Professional,Total',
            'current_month' => 'nullable|date_format:Y-m',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $selectedCategory = $validatedData['category'] ?? null;
        $currentMonth = $validatedData['current_month'] ?? null;
        $startDate = $validatedData['start_date'] ?? null;
        $endDate = $validatedData['end_date'] ?? null;

        // Base query for expenses
        $expensesQuery = DB::table('expenses');

        // Base query for payments
        $exQuery = DB::table('collect_fees');



        // if ($selectedCategory === 'Total') {
        //     $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
        // } elseif ($selectedCategory) {
        //     $expensesQuery->where('source_of_expense', $selectedCategory);
        // } else {
        //     $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
        // }

        $bebelino = $expensesQuery->get();

        return $bebelino;
    }

    public function calculateBalanceTota(Request $request) {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'category' => 'nullable|string|in:Academic,Professional,Total',
                'current_month' => 'nullable|date_format:Y-m',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date'
            ]);
    
            $selectedCategory = $validatedData['category'] ?? null;
            $currentMonth = $validatedData['current_month'] ?? null;
            $startDate = $validatedData['start_date'] ?? null;
            $endDate = $validatedData['end_date'] ?? null;
    
            // Base query for expenses
            $expensesQuery = DB::table('expenses');
    
            // Apply category filter for expenses
            if ($selectedCategory === 'Total') {
                $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
            } elseif ($selectedCategory) {
                $expensesQuery->where('source_of_expense', $selectedCategory);
            } else {
                $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
            }
    
            // Apply date filters for expenses
            if ($currentMonth) {
                $expensesQuery->whereYear('created_at', date('Y', strtotime($currentMonth)))
                               ->whereMonth('created_at', date('m', strtotime($currentMonth)));
            } elseif ($startDate && $endDate) {
                $expensesQuery->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $expensesQuery->where('created_at', '>=', $startDate);
            } elseif ($endDate) {
                $expensesQuery->where('created_at', '<=', $endDate);
            }

            // Calculate expenses totals
            $expensesTotals = $expensesQuery->select(
                'source_of_expense',
                DB::raw('SUM(amount) as total')
            )->groupBy('source_of_expense')->pluck('total', 'source_of_expense');
    
            $expensesAcademicTotal = $expensesTotals['Academic'] ?? 0;
            $expensesProfessionalTotal = $expensesTotals['Professional'] ?? 0;
    
            // Query for fee collections
            $feeCollectionsQuery = DB::table('collect_fees')
                ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
                ->whereIn('students.student_category', ['Academic', 'Professional']);
            
            
    
            // Apply date filters to fee collections
            if ($currentMonth) {
                $feeCollectionsQuery->whereYear('collect_fees.created_at', date('Y', strtotime($currentMonth)))
                                    ->whereMonth('collect_fees.created_at', date('m', strtotime($currentMonth)));
            } elseif ($startDate && $endDate) {
                $feeCollectionsQuery->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $feeCollectionsQuery->where('collect_fees.created_at', '>=', $startDate);
            } elseif ($endDate) {
                $feeCollectionsQuery->where('collect_fees.created_at', '<=', $endDate);
            }
    
            // Group by category and get totals
            $feeCollections = $feeCollectionsQuery->select(
                'students.student_category',
                DB::raw('SUM(collect_fees.amount) as total')
            )->groupBy('students.student_category')->pluck('total', 'students.student_category');
    
            // Extract totals
            $totalCollectionsAcademic = $feeCollections['Academic'] ?? 0;
            $totalCollectionsProfessional = $feeCollections['Professional'] ?? 0;
    
            // Compute balances
            $totalAcademicBalance = $totalCollectionsAcademic - $expensesAcademicTotal;
            $totalProfessionalBalance = $totalCollectionsProfessional - $expensesProfessionalTotal;
    
            // Determine which view to return
            if ($selectedCategory === 'Academic') {
                return view('backend.reports.getbalancereportacademic', compact(
                    'totalAcademicBalance', 'totalCollectionsAcademic', 'expensesAcademicTotal', 'selectedCategory','currentMonth','startDate','endDate'
                ));
            } elseif ($selectedCategory === 'Professional') {
                return view('backend.reports.getbalancereportprofessional', compact(
                    'totalProfessionalBalance', 'totalCollectionsProfessional', 'expensesProfessionalTotal', 'selectedCategory','currentMonth','startDate','endDate'
                ));
            } elseif ($selectedCategory === 'Total') {
                $totalCombinedBalance = $totalAcademicBalance + $totalProfessionalBalance;
                $totalCombinedCollections = $totalCollectionsAcademic + $totalCollectionsProfessional;
                $totalCombinedExpenses = $expensesAcademicTotal + $expensesProfessionalTotal;
    
                return view('backend.reports.getbalancereporttotal', compact(
                    'totalCombinedBalance', 'totalCombinedCollections', 'totalCombinedExpenses', 'selectedCategory','currentMonth','startDate','endDate'
                ));
            }
    
            return redirect()->back()->with('error', 'Invalid category selection.');
    
        } catch (Exception $e) {
            Log::error('Error occurred while generating the balance report', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
        }
    }

    // public function calculateBalanceTotal(Request $request) {
    //     try {
    //         // Validate the request data
    //         dd($request->all());
    //         $validatedData = $request->validate([
    //             'category' => 'nullable|string|in:Academic,Professional,Total',
    //             'current_date' => 'nullable|date',
    //             'start_date' => 'nullable|date',
    //             'mode_of_payment' => 'nullable|string|in:Cash,Mobile Money,Bank Transfer',
    //             'end_date' => 'nullable|date|after_or_equal:start_date'
    //         ]);
    
    //         $selectedCategory = $validatedData['category'] ?? null;
    //         $currentDate = $validatedData['current_date'] ?? null;
    //         $startDate = $validatedData['start_date'] ?? null;
    //         $endDate = $validatedData['end_date'] ?? null;
    //         $modeOfPayment = $validatedData['mode_of_payment'] ?? null;

    //         // ========== FORM FEES COLLECTIONS ==========
    //         $formFeesQuery = DB::table('student_enquires');

    //         if($currentDate) {
    //             $formFeesQuery->whereDate('created_at',$currentDate);
  
    //         } elseif ($startDate && $endDate) {
    //             $formFeesQuery->whereBetween('created_at', [$startDate, $endDate]);
    //         }

    //         $formFeesBebelinos = $formFeesQuery->where('bought_forms','Yes')->get();
    //         $formFeesAllAmount = $formFeesBebelinos->sum('amount');

    //         $formFeesTransactions = $formFeesQuery
    //             ->where('bought_forms', 'Yes')
    //             ->where('type_of_course', $selectedCategory)
    //             ->get();
            

    //         $formFeesTotals = $formFeesTransactions->sum('amount');
    
    //         // ========== EXPENSES ==========
    //         $expensesQuery = DB::table('expenses');
    
    //         // Apply category filter for expenses
    //         if ($selectedCategory === 'Total') {
    //             $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
    //         } elseif ($selectedCategory) {
    //             $expensesQuery->where('source_of_expense', $selectedCategory);
    //         } else {
    //             $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
    //         }
    
    //         // Apply date filters for expenses
    //         if ($currentDate) {
    //             $formFeesQuery->whereDate('created_at',$currentDate);
    //         } elseif ($startDate && $endDate) {
    //             $expensesQuery->whereBetween('created_at', [$startDate, $endDate]);
    //         } elseif ($startDate) {
    //             $expensesQuery->where('created_at', '>=', $startDate);
    //         } elseif ($endDate) {
    //             $expensesQuery->where('created_at', '<=', $endDate);
    //         }
    
    //         // Get expenses transactions
    //         $expensesTransactions = $expensesQuery->get();

    //         $totalExpensesByCash = $expensesTransactions->where('mode_of_payment','Cash')->sum('amount');

    //         $totalExpensesByMomo = $expensesTransactions->where('mode_of_payment','Mobile Money')->sum('amount');

    //         $totalExpensesByBankTransfer = $expensesTransactions->where('mode_of_payment','Bank Transfer')->sum('amount');

    //         $expensesTotalAmount = $expensesTransactions->sum('amount');
            
    //         // Calculate expenses totals
    //         $expensesTotals = $expensesTransactions->groupBy('source_of_expense')
    //             ->map(function ($items) {
    //                 return $items->sum('amount');
    //             });
    
    //         $expensesAcademicTotal = $expensesTotals['Academic'] ?? 0;
    //         $expensesProfessionalTotal = $expensesTotals['Professional'] ?? 0;
    
    //         // ========== SCHOOL FEES COLLECTIONS ==========
    //         $feeCollectionsQuery = DB::table('collect_fees')
    //             ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
    //             ->whereIn('students.student_category', ['Academic', 'Professional']);

    
    //         // Apply date filters to fee collections
    //         if ($currentDate) {
    //             $feeCollectionsQuery->whereDate('collect_fees.created_at',$currentDate);
    //         } elseif ($startDate && $endDate) {
    //             $feeCollectionsQuery->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
    //         } elseif ($startDate) {
    //             $feeCollectionsQuery->where('collect_fees.created_at', '>=', $startDate);
    //         } elseif ($endDate) {
    //             $feeCollectionsQuery->where('collect_fees.created_at', '<=', $endDate);
    //         }
    
    //         // Get fee collection transactions with student info
    //         $feeCollectionTransactions = $feeCollectionsQuery
    //             ->select(
    //                 'collect_fees.*',
    //                 'students.student_category',
    //             )
    //             ->get();
    //         $totalSchoolFeesByCash = $feeCollectionTransactions->where('method_of_payment','Cash')->sum('amount');
    //         $totalSchoolFeesByMomo = $feeCollectionTransactions->where('method_of_payment','Momo')->sum('amount');
    //         $totalSchoolFeesByCheque = $feeCollectionTransactions->where('method_of_payment','Cheque')->sum('amount');
            
    //         $feesPaymentsTotal = $feeCollectionTransactions->sum('amount');
            
    //         $feesTransactions = $feeCollectionTransactions->where('student_category',$selectedCategory)->all();
    
    //         // Calculate fee collection totals
    //         $feeCollectionsTotals = $feeCollectionTransactions->groupBy('student_category')
    //             ->map(function ($items) {
    //                 return $items->sum('amount');
    //             });

    //         $totalCollectionsAcademic = $feeCollectionsTotals['Academic'] ?? 0;
    //         $totalCollectionsProfessional = $feeCollectionsTotals['Professional'] ?? 0;
    
    //         // Compute balances
    //         $totalAcademicBalance = $totalCollectionsAcademic - $expensesAcademicTotal;
    //         $totalProfessionalBalance = $totalCollectionsProfessional - $expensesProfessionalTotal;
    //         $totalCombinedBalance = $totalAcademicBalance + $totalProfessionalBalance;
    //         $totalCombinedCollections = $totalCollectionsAcademic + $totalCollectionsProfessional;
    //         $totalCombinedExpenses = $expensesAcademicTotal + $expensesProfessionalTotal;
    
    //         // Prepare data for view
    //         $data = [
    //             'selectedCategory' => $selectedCategory,
    //             'currentDate' => $currentDate,
    //             'startDate' => $startDate,
    //             'endDate' => $endDate,
                
    //             // Transactions
    //             'expensesTransactions' => $expensesTransactions,
    //             'feeCollectionTransactions' => $feeCollectionTransactions,
                
    //             // Academic totals
    //             'expensesAcademicTotal' => $expensesAcademicTotal,
    //             'totalCollectionsAcademic' => $totalCollectionsAcademic,
    //             'totalAcademicBalance' => $totalAcademicBalance,
                
    //             // Professional totals
    //             'expensesProfessionalTotal' => $expensesProfessionalTotal,
    //             'totalCollectionsProfessional' => $totalCollectionsProfessional,
    //             'totalProfessionalBalance' => $totalProfessionalBalance,
                
    //             // Combined totals
    //             'totalCombinedExpenses' => $totalCombinedExpenses,
    //             'totalCombinedCollections' => $totalCombinedCollections,
    //             'totalCombinedBalance' => $totalCombinedBalance,
    //         ];
    
    //         // Return view based on category
    //         if ($selectedCategory === 'Academic') {
    //             return view('backend.reports.getbalancereportacademic', compact('totalSchoolFeesByCheque','totalSchoolFeesByMomo','totalSchoolFeesByCash','selectedCategory','currentDate','startDate','endDate','expensesTransactions','feeCollectionTransactions','expensesAcademicTotal','totalCollectionsAcademic','totalAcademicBalance','totalCombinedExpenses','totalCombinedCollections','totalCombinedBalance','formFeesTransactions','formFeesTotals','feesTransactions'));
    //         } elseif ($selectedCategory === 'Professional') {
    //             return view('backend.reports.getbalancereportprofessional',compact('selectedCategory','currentDate','startDate','endDate','expensesProfessionalTotal','totalCollectionsProfessional','totalProfessionalBalance','expensesTransactions','feeCollectionTransactions','formFeesTransactions','formFeesTotals','feesTransactions'));
    //         } elseif ($selectedCategory === 'Total') {
    //             return view('backend.reports.getbalancereporttotal', compact('formFeesBebelinos','formFeesAllAmount','feeCollectionTransactions','expensesTransactions','expensesTotalAmount','feesPaymentsTotal'));
    //         }
    //     } catch (Exception $e) {
    //         Log::error('Error occurred while generating the balance report', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    
    //         return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
    //     }
    // }

    public function calculateBalanceTotal(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'category' => 'nullable|string|in:Academic,Professional,Total',
                'current_date' => 'nullable|date',
                'start_date' => 'nullable|date',
                'mode_of_payment' => 'nullable|string|in:Cash,Mobile Money,Bank Transfer',
                'end_date' => 'nullable|date|after_or_equal:start_date'
            ]);

            $selectedCategory = $validatedData['category'] ?? null;
            $currentDate = $validatedData['current_date'] ?? null;
            $startDate = $validatedData['start_date'] ?? null;
            $endDate = $validatedData['end_date'] ?? null;
            $modeOfPayment = $validatedData['mode_of_payment'] ?? null;

            // ========== FORM FEES ==========
            $formFeesQuery = DB::table('student_enquires');
            if ($currentDate) {
                $formFeesQuery->whereDate('created_at', $currentDate);
            } elseif ($startDate && $endDate) {
                $formFeesQuery->whereBetween('created_at', [$startDate, $endDate]);
            }

            $formFeesBebelinos = $formFeesQuery->where('bought_forms', 'Yes')->get();
            $formFeesAllAmount = $formFeesBebelinos->sum('amount');

            $formFeesTransactions = $formFeesQuery
                ->where('bought_forms', 'Yes')
                ->when($selectedCategory, function ($query) use ($selectedCategory) {
                    return $query->where('type_of_course', $selectedCategory);
                }, function ($query) {
                    return $query->whereIn('type_of_course', ['Academic', 'Professional']);
                })->get();

            $formFeesTotals = $formFeesTransactions->sum('amount');

            // ========== EXPENSES ==========
            $expensesQuery = DB::table('expenses');
            if($selectedCategory === 'Academic' || $selectedCategory === 'Professional') {
                $expensesQuery->where('source_of_expense', $selectedCategory);
            } else {
                $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
            }
            // if ($selectedCategory === 'Total') {
            //     $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
            // } elseif ($selectedCategory) {
            //     $expensesQuery->where('source_of_expense', $selectedCategory);
            // } else {
            //     $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
            // }
            if($modeOfPayment === 'Cash' || $modeOfPayment === 'Mobile Money' || $modeOfPayment === 'Bank Transfer') {
                $expensesQuery->where('mode_of_payment', $modeOfPayment);
            } else {
                $expensesQuery->whereIn('mode_of_payment',['Cash','Mobile Money','Bank Transfer']);
            }

            if ($currentDate) {
                $expensesQuery->whereDate('created_at', $currentDate);
            } elseif ($startDate && $endDate) {
                $expensesQuery->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $expensesQuery->where('created_at', '>=', $startDate);
            } elseif ($endDate) {
                $expensesQuery->where('created_at', '<=', $endDate);
            }

            $expensesTransactions = $expensesQuery->get();
            $expensesTotalAmount = $expensesTransactions->sum('amount');

            $expensesTransactions = $expensesQuery->get();
            $expensesTotalAmount = $expensesTransactions->sum('amount');

            $expensesTotals = $expensesTransactions->groupBy('source_of_expense')
                ->map(fn($items) => $items->sum('amount'));

            $expensesAcademicTotal = $expensesTotals['Academic'] ?? 0;
            $expensesProfessionalTotal = $expensesTotals['Professional'] ?? 0;

            // ========== SCHOOL FEES ==========
            $feeCollectionsQuery = DB::table('collect_fees')
                ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
                ->whereIn('students.student_category', ['Academic', 'Professional']);

            $paymentMethodMap = [
                'Cash' => 'Cash',
                'Mobile Money' => 'Momo',
                'Bank Transfer' => 'Cheque'
            ];

            if (isset($paymentMethodMap[$modeOfPayment])) {
                $feeCollectionsQuery->where('method_of_payment', $paymentMethodMap[$modeOfPayment]);
            }

            if ($currentDate) {
                $feeCollectionsQuery->whereDate('collect_fees.created_at', $currentDate);
            } elseif ($startDate && $endDate) {
                $feeCollectionsQuery->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $feeCollectionsQuery->where('collect_fees.created_at', '>=', $startDate);
            } elseif ($endDate) {
                $feeCollectionsQuery->where('collect_fees.created_at', '<=', $endDate);
            }

            $feeCollectionTransactions = $feeCollectionsQuery
                ->select('collect_fees.*', 'students.student_category')
                ->get();   
 
            $feesPaymentsTotal = $feeCollectionTransactions->sum('amount');

            // $feesTransactions = $feeCollectionTransactions->where('student_category',$selectedCategory)->all();
            $feesTransactions = in_array($selectedCategory, ['Academic', 'Professional']) 
                    ? $feeCollectionTransactions->where('student_category', $selectedCategory)->all()
                    : $feeCollectionTransactions->whereIn('student_category', ['Academic', 'Professional'])->all();
            // return $feesTransactions;

            $feeCollectionsTotals = $feeCollectionTransactions->groupBy('student_category')
                ->map(fn($items) => $items->sum('amount'));

            $totalCollectionsAcademics = $feeCollectionsTotals['Academic'] ?? 0;
            $totalCollectionsProfessional = $feeCollectionsTotals['Professional'] ?? 0;

            // ========== BALANCE PER CATEGORY ==========
            $totalAcademicBalance = $totalCollectionsAcademics - $expensesAcademicTotal;
            $totalProfessionalBalance = $totalCollectionsProfessional - $expensesProfessionalTotal;
            $totalCombinedBalance = $totalAcademicBalance + $totalProfessionalBalance;
            $totalCombinedCollections = $totalCollectionsAcademics + $totalCollectionsProfessional;
            $totalCombinedExpenses = $expensesAcademicTotal + $expensesProfessionalTotal;

            // ========== GROUPED BY CATEGORY + PAYMENT MODE ==========
            $collectionsByCategoryAndMode = $feeCollectionTransactions->groupBy(['student_category', 'method_of_payment'])
                ->map(fn($categoryGroup) =>
                    $categoryGroup->map(fn($items) => $items->sum('amount'))
                );

                // return $collectionsByCategoryAndMode;

            $expensesByCategoryAndMode = $expensesTransactions->groupBy(['source_of_expense', 'mode_of_payment'])
                ->map(fn($categoryGroup) =>
                    $categoryGroup->map(fn($items) => $items->sum('amount'))
                );

                // return $expensesByCategoryAndMode;

            $balanceByCategoryAndMode = [];
            foreach (['Academic', 'Professional'] as $category) {
                foreach (['Cash', 'Momo', 'Cheque'] as $mode) {
                    $collections = $collectionsByCategoryAndMode[$category][$mode] ?? 0;
                    $expenses = $expensesByCategoryAndMode[$category][$mode] ?? 0;
                    $balanceByCategoryAndMode[$category][$mode] = $collections - $expenses;
                }
            }

            // View Data
            $data = [
                'selectedCategory' => $selectedCategory,
                'currentDate' => $currentDate,
                'startDate' => $startDate,
                'endDate' => $endDate,

                'expensesTransactions' => $expensesTransactions,
                'feeCollectionTransactions' => $feeCollectionTransactions,
                'feesTransactions' => $feesTransactions,

                'expensesAcademicTotal' => $expensesAcademicTotal,
                'totalCollectionsAcademics' => $totalCollectionsAcademics,
                'totalAcademicBalance' => $totalAcademicBalance,

                'expensesProfessionalTotal' => $expensesProfessionalTotal,
                'totalCollectionsProfessional' => $totalCollectionsProfessional,
                'totalProfessionalBalance' => $totalProfessionalBalance,

                'totalCombinedExpenses' => $totalCombinedExpenses,
                'totalCombinedCollections' => $totalCombinedCollections,
                'totalCombinedBalance' => $totalCombinedBalance,

                'formFeesTransactions' => $formFeesTransactions,
                'formFeesTotals' => $formFeesTotals,
                'formFeesBebelinos' => $formFeesBebelinos,
                'formFeesAllAmount' => $formFeesAllAmount,
                'feesPaymentsTotal' => $feesPaymentsTotal,
                'expensesTotalAmount' => $expensesTotalAmount,

                'collectionsByCategoryAndMode' => $collectionsByCategoryAndMode,
                'expensesByCategoryAndMode' => $expensesByCategoryAndMode,
                'balanceByCategoryAndMode' => $balanceByCategoryAndMode,
            ];

            // View response
            if ($selectedCategory === 'Academic') {
                return view('backend.reports.getbalancereportacademic', $data);
            } elseif ($selectedCategory === 'Professional') {
                return view('backend.reports.getbalancereportprofessional', $data);
            } elseif ($selectedCategory === 'Total') {
                return view('backend.reports.getbalancereporttotal', $data);
            }

        } catch (Exception $e) {
            Log::error('Error occurred while generating the balance report', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
        }
    }
}

