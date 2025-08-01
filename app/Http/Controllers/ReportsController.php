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
use Carbon\Carbon;
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
            // dd($request->all());
            $validatedData = $request->validate([
                'diplomaID' => 'required|integer|exists:diploma,id',
                'branch' => 'nullable|in:Kasoa,Kanda,Spintex'
            ]);

            $diplomaID = $validatedData['diplomaID'];
            $branch = $validatedData['branch'];

            $diploma = Diploma::findOrFail($diplomaID);
    
        // $diplomaID = $request->input('diplomaID');

        $students = Student::with(['user', 'diploma'])
            ->whereHas('diploma', function ($query) {
                // Ensure the student is associated with a diploma
                $query->whereNotNull('id'); // Assuming 'id' is the primary key of the diplomas table
            })
            ->when($diplomaID, function ($query, $diplomaID) {
                return $query->whereHas('diploma', function ($q) use ($diplomaID) {
                    $q->where('id', $diplomaID); // Filter by subject ID
                });
            })
            ->when($branch, function($query, $branch) {
                return $query->where('branch', $branch);
            })
            ->get();

            // return $students;

            
        $totalStudents = $students->count();
        return view('backend.reports.studentreport', compact('students', 'diplomaID','totalStudents','diploma','branch'));
            
        } catch (Exception $e) {
            //throw $th;
        Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
             
            
    
            // // Pass data to the view
            // return view('backend.reports.studentreport', compact('students', 'start_date', 'end_date', 'diploma'));
    
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
            $validatedData = $request->validate([
                'courseID' => 'required',
                'level' => 'nullable|in:100,200,300,400',
                'semester' => 'nullable|in:1,2',
                'branch' => 'nullable|in:Kasoa,Kanda,Spintex'
            ]);

            $courseID = $validatedData['courseID'];
            $level = $validatedData['level'];
            $semester = $validatedData['semester'];
            $branch = $validatedData['branch'];

            $courseAcademic = Grade::findOrFail($courseID)->course_name;

            $query = DB::table('students')
                ->join('users', 'students.user_id', '=', 'users.id')
                ->leftJoin('grades', 'students.course_id', '=', 'grades.id')
                ->select(
                    'students.*',
                    'users.name as user_name',
                    'grades.course_name as course_name'
                )
                ->where('students.student_category','Academic');
            
            if (!empty($courseID)) {
                $query->where('course_id', $courseID);
            }

            if (!empty($level)) {
                $query->where('level', $level);
            }

            if (!empty($semester)) {
                $query->where('session', $semester);
            }

            if (!empty($branch)) {
                $query->where('branch', $branch);
            }

            $students = $query->get();
            $totalCount = $students->count();

            // return [$students, $students->count()];

            return view('backend.reports.studentsacademicreport',compact('level','semester','students','totalCount','courseAcademic','branch'));
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return redirect()->back()->with('error', 'Problem with the query');    
        }
    }

    // public function generatePaymentReport(Request $request)
    // {
    //     try {
    //         // dd($request->all());
    //         $validatedData = $request->validate([
    //             'current_date' => 'nullable|date',
    //             'start_date' => 'nullable|date',
    //             'end_date' => 'nullable|date',
    //             'aca_prof' => 'nullable|in:Academic,Professional,All',
    //             'branch' => 'nullable|in:Kasoa,Kanda,Spintex',
    //             'method_of_payment' => 'nullable|in:Cash,Momo,Cheque'
    //         ]);

    //         $currentDate = $validatedData['current_date'] ?? null;
    //         $startDate = $validatedData['start_date'] ?? null;
    //         $endDate = $validatedData['end_date'] ?? null;
    //         $aca_prof = $validatedData['aca_prof'] ?? 'All';
    //         $branch = $validatedData['branch'] ?? null;
    //         $methodOfPayment = $validatedData['method_of_payment'];

    //         // Step 1: Get unique student index numbers from the collect_fees table
    //         $uniqueIndexNumbers = FeesPaid::distinct()->pluck('student_index_number');

    //         // Step 2: Fetch student categories for the unique index numbers
    //         // $students = Student::whereIn('index_number', $uniqueIndexNumbers)
    //         //     ->pluck('student_category', 'index_number');

    //         $students = Student::whereIn('index_number',$uniqueIndexNumbers)
    //         ->select('index_number','student_category','branch')
    //         ->get()
    //         ->mapWithKeys(function($student) {
    //             return[
    //                 $student->index_number => [
    //                     'student_category' => $student->student_category,
    //                     'branch' => $student->branch,
    //                 ]
    //             ];
    //         });

    //         // return $students;
    //         // Step 3: Filter index numbers based on category selection
    //         $filteredIndexNumbers = $students->filter(function ($category) use ($aca_prof) {
    //             $categoryLower = strtolower($category);
    //             $acaProfLower = strtolower($aca_prof);

    //             return ($acaProfLower === 'all') 
    //                 ? in_array($categoryLower, ['academic', 'professional'])
    //                 : ($categoryLower === $acaProfLower);
    //         })->keys();

    //         // Step 4: Fetch all fee transactions with filters
    //         $feeTransactionsQuery = FeesPaid::whereIn('student_index_number', $filteredIndexNumbers);

    //         // dd($feeTransactionsQuery->get());

    //         // Apply date filters
    //         if ($startDate && $endDate) {
    //             $feeTransactionsQuery->whereBetween('created_at', [$startDate, $endDate]);
    //         } elseif ($startDate) {
    //             $feeTransactionsQuery->where('created_at', '>=', $startDate);
    //         } elseif ($endDate) {
    //             $feeTransactionsQuery->where('created_at', '<=', $endDate);
    //         } elseif ($currentDate) {
    //             $feeTransactionsQuery->whereDate('created_at', $currentDate);
    //         }

    //         if($methodOfPayment) {
    //             $feeTransactionsQuery->where('method_of_payment', $methodOfPayment);
    //         }

    //         $feeTransactions = $feeTransactionsQuery->get();

    //         // return $feeTransactions;

    //         // Calculate payment method totals
    //         $method_of_Payment_Total = $feeTransactions->where('method_of_payment', $methodOfPayment)->sum('amount');
    //         $momoTotal = $feeTransactions->where('method_of_payment', 'Momo')->sum('amount');
    //         $chequeTotal = $feeTransactions->where('method_of_payment', 'Cheque')->sum('amount');
    //         $cashTotal = $feeTransactions->where('method_of_payment', 'Cash')->sum('amount');

    //         // Step 5: Group transactions by student category and currency
    //         $transactionsByCategoryAndCurrency = [
    //             'academic' => [],
    //             'professional' => [],
    //             'total' => []
    //         ];

    //         foreach ($feeTransactions as $transaction) {
    //             $indexNumber = $transaction->student_index_number;
    //             $category = strtolower($students[$indexNumber] ?? 'unknown');
    //             $currency = $transaction->currency;

    //             if (array_key_exists($category, $transactionsByCategoryAndCurrency)) {
    //                 if (!isset($transactionsByCategoryAndCurrency[$category][$currency])) {
    //                     $transactionsByCategoryAndCurrency[$category][$currency] = [];
    //                 }
    //                 $transactionsByCategoryAndCurrency[$category][$currency][] = $transaction;
    //             }
    //         }

    //         // Step 6: Calculate totals for each category and currency
    //         $totalsByCategoryAndCurrency = [
    //             'academic' => [],
    //             'professional' => [],
    //             'total' => []
    //         ];

    //         foreach ($transactionsByCategoryAndCurrency as $category => $currencies) {
    //             foreach ($currencies as $currency => $transactions) {
    //                 $totalsByCategoryAndCurrency[$category][$currency] = collect($transactions)->sum('amount');
    //             }
    //         }

    //         // dd($totalsByCategoryAndCurrency);

    //         // Calculate bought forms amount
    //         $boughtFormsAmount = Enquiry::where('bought_forms', 'Yes')->sum(DB::raw('CAST(amount AS DECIMAL)'));

    //         return view('backend.reports.paymentreport', [
    //             'transactionsByCategoryAndCurrency' => $transactionsByCategoryAndCurrency,
    //             'totalsByCategoryAndCurrency' => $totalsByCategoryAndCurrency,
    //             'currentDate' => $currentDate,
    //             'startDate' => $startDate,
    //             'endDate' => $endDate,
    //             'aca_prof' => $aca_prof,
    //             'boughtFormsAmount' => $boughtFormsAmount,
    //             'method_of_Payment_Total' => $method_of_Payment_Total,
    //             'methodOfPayment' => $methodOfPayment,
    //             'cashTotal' => $cashTotal,
    //             'momoTotal' => $momoTotal,
    //             'chequeTotal' => $chequeTotal
    //         ]);

    //     } catch (Exception $e) {
    //         Log::error('Error generating payment report', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
    //     }
    // }

    public function generatePaymentReport(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'current_date' => 'nullable|date',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'aca_prof' => 'nullable|in:Academic,Professional,All',
                'branch' => 'nullable|in:Kasoa,Kanda,Spintex',
                'method_of_payment' => 'nullable|in:Cash,Momo,Cheque'
            ]);

            $currentDate = $validatedData['current_date'] ?? null;
            $startDate = $validatedData['start_date'] ?? null;
            $endDate = $validatedData['end_date'] ?? null;
            $aca_prof = $validatedData['aca_prof'] ?? 'All';
            $branch = $validatedData['branch'] ?? null;
            $methodOfPayment = $validatedData['method_of_payment'] ?? null;

            // Step 1: Get unique student index numbers from the collect_fees table
            $uniqueIndexNumbers = FeesPaid::distinct()->pluck('student_index_number');

            // Step 2: Fetch student categories for the unique index numbers and apply branch filter
            $studentsQuery = Student::whereIn('index_number', $uniqueIndexNumbers)
                ->select('index_number', 'student_category', 'branch');

            if ($branch) {
                $studentsQuery->where('branch', $branch);
            }

            $students = $studentsQuery->get()->mapWithKeys(function ($student) {
                return [
                    $student->index_number => [
                        'student_category' => $student->student_category,
                        'branch' => $student->branch,
                    ]
                ];
            });

            // Optional: Early return if no students match
            if ($students->isEmpty()) {
                return view('backend.reports.paymentreport', [
                    'transactionsByCategoryAndCurrency' => [],
                    'totalsByCategoryAndCurrency' => [],
                    'currentDate' => $currentDate,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'aca_prof' => $aca_prof,
                    'boughtFormsAmount' => 0,
                    'method_of_Payment_Total' => 0,
                    'methodOfPayment' => $methodOfPayment,
                    'cashTotal' => 0,
                    'momoTotal' => 0,
                    'chequeTotal' => 0
                ])->with('info', 'No students found for the selected branch.');
            }

            // Step 3: Filter index numbers based on category selection
            $filteredIndexNumbers = $students->filter(function ($info) use ($aca_prof) {
                $category = strtolower($info['student_category']);
                $acaProfLower = strtolower($aca_prof);

                return ($acaProfLower === 'all') 
                    ? in_array($category, ['academic', 'professional'])
                    : ($category === $acaProfLower);
            })->keys();

            // Step 4: Fetch all fee transactions with filters
            $feeTransactionsQuery = FeesPaid::whereIn('student_index_number', $filteredIndexNumbers);

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

            if ($methodOfPayment) {
                $feeTransactionsQuery->where('method_of_payment', $methodOfPayment);
            }

            $feeTransactions = $feeTransactionsQuery->get();

            // Calculate payment method totals
            $method_of_Payment_Total = $methodOfPayment ? $feeTransactions->where('method_of_payment', $methodOfPayment)->sum('amount') : 0;
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
                $category = strtolower($students[$indexNumber]['student_category'] ?? 'unknown');
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
                'chequeTotal' => $chequeTotal,
                'branch' => $branch
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

    private function computeBalancesTillDate($date, $selectedCategory = null, $modeOfPayment = null)
{
    $expensesQuery = DB::table('expenses')
        ->whereDate('created_at', '<=', $date);

    if ($selectedCategory && in_array($selectedCategory, ['Academic', 'Professional'])) {
        $expensesQuery->where('source_of_expense', $selectedCategory);
    } else {
        $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
    }

    if ($modeOfPayment) {
        $expensesQuery->where('mode_of_payment', $modeOfPayment);
    }

    $expenses = $expensesQuery->get()->groupBy('source_of_expense')
        ->map(fn($items) => $items->sum('amount'));

    $academicExpenses = $expenses['Academic'] ?? 0;
    $professionalExpenses = $expenses['Professional'] ?? 0;

    $feeQuery = DB::table('collect_fees')
        ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
        ->whereDate('collect_fees.created_at', '<=', $date)
        ->whereIn('students.student_category', ['Academic', 'Professional']);

    $paymentMethodMap = [
        'Cash' => 'Cash',
        'Mobile Money' => 'Momo',
        'Bank Transfer' => 'Cheque'
    ];

    if (isset($paymentMethodMap[$modeOfPayment])) {
        $feeQuery->where('method_of_payment', $paymentMethodMap[$modeOfPayment]);
    }

    $fees = $feeQuery->select('collect_fees.*', 'students.student_category')->get()
        ->groupBy('student_category')
        ->map(fn($items) => $items->sum('amount'));

    $academicFees = $fees['Academic'] ?? 0;
    $professionalFees = $fees['Professional'] ?? 0;

    return [
        'academicBalance' => $academicFees - $academicExpenses,
        'professionalBalance' => $professionalFees - $professionalExpenses,
        'combinedBalance' => ($academicFees - $academicExpenses) + ($professionalFees - $professionalExpenses),
    ];
    }
    

//  public function calculateBalanceTotal(Request $request)
// {
//     try {
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
//         $yesterday = Carbon::parse($currentDate ?? $startDate)->subDay()->toDateString();
        
//         // ========== FORM FEES ==========
//         $formFeesQuery = DB::table('student_enquires');
//         if ($currentDate) {
//             $formFeesQuery->whereDate('created_at', $currentDate);
//         } elseif ($startDate && $endDate) {
//             $formFeesQuery->whereBetween('created_at', [$startDate, $endDate]);
//         }

//         $formFeesBebelinos = $formFeesQuery->where('bought_forms', 'Yes')->get();
//         $formFeesAllAmount = $formFeesBebelinos->sum(function ($item) {
//             return (float) $item->amount;
//         });
//         $formFeesTransactions = $formFeesQuery
//             ->where('bought_forms', 'Yes')
//             ->when($selectedCategory, fn($q) => $q->where('type_of_course', $selectedCategory), fn($q) => $q->whereIn('type_of_course', ['Academic', 'Professional']))
//             ->get();

//         // return $formFeesTransactions;

//         $formFeesTotals = $formFeesTransactions->sum('amount');

//         // ========== EXPENSES ==========
//         $expensesQuery = DB::table('expenses');
//         if (in_array($selectedCategory, ['Academic', 'Professional'])) {
//             $expensesQuery->where('source_of_expense', $selectedCategory);
//         } else {
//             $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
//         }

//         if ($modeOfPayment) {
//             $expensesQuery->whereIn('mode_of_payment', ['Cash', 'Mobile Money', 'Bank Transfer']);
//             $expensesQuery->where('mode_of_payment', $modeOfPayment);
//         }

//         if ($currentDate) {
//             $expensesQuery->whereDate('created_at', $currentDate);
//         } elseif ($startDate && $endDate) {
//             $expensesQuery->whereBetween('created_at', [$startDate, $endDate]);
//         } elseif ($startDate) {
//             $expensesQuery->where('created_at', '>=', $startDate);
//         } elseif ($endDate) {
//             $expensesQuery->where('created_at', '<=', $endDate);
//         }

//         $expensesTransactions = $expensesQuery->get();
//         $expensesTotalAmount = $expensesTransactions->sum(fn($item) => (float) $item->amount);

//         $expensesTotals = $expensesTransactions->groupBy('source_of_expense')
//         ->map(fn($items) => $items->sum(fn($item) => (float) $item->amount));
    
//         $expensesAcademicTotal = $expensesTotals['Academic'] ?? 0;
//         $expensesProfessionalTotal = $expensesTotals['Professional'] ?? 0;

//         // ========== SCHOOL FEES ==========
//         $feeCollectionsQuery = DB::table('collect_fees')
//             ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
//             ->whereIn('students.student_category', ['Academic', 'Professional']);

//         $paymentMethodMap = [
//             'Cash' => 'Cash',
//             'Mobile Money' => 'Momo',
//             'Bank Transfer' => 'Cheque'
//         ];

//         if (isset($paymentMethodMap[$modeOfPayment])) {
//             $feeCollectionsQuery->where('method_of_payment', $paymentMethodMap[$modeOfPayment]);
//         }
// if ($currentDate) {
//             $feeCollectionsQuery->whereDate('collect_fees.created_at', $currentDate);
//         } elseif ($startDate && $endDate) {
//             $feeCollectionsQuery->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
//         } elseif ($startDate) {
//             $feeCollectionsQuery->where('collect_fees.created_at', '>=', $startDate);
//         } elseif ($endDate) {
//             $feeCollectionsQuery->where('collect_fees.created_at', '<=', $endDate);
//         }

//         $feeCollectionTransactions = $feeCollectionsQuery
//             ->select('collect_fees.*', 'students.student_category')
//             ->get();

//         $feesPaymentsTotal = $feeCollectionTransactions->sum(fn($item) => (float) $item->amount);


//         $feesTransactions = in_array($selectedCategory, ['Academic', 'Professional'])
//             ? $feeCollectionTransactions->where('student_category', $selectedCategory)->all()
//             : $feeCollectionTransactions->whereIn('student_category', ['Academic', 'Professional'])->all();

//         $feeCollectionsTotals = $feeCollectionTransactions->groupBy('student_category')
//         ->map(fn($items) => $items->sum(fn($item) => (float) $item->amount));
        

//         $totalCollectionsAcademics = $feeCollectionsTotals['Academic'] ?? 0;
//         $totalCollectionsProfessional = $feeCollectionsTotals['Professional'] ?? 0;

//         $totalAcademicBalance = $totalCollectionsAcademics - $expensesAcademicTotal;
//         $totalProfessionalBalance = $totalCollectionsProfessional - $expensesProfessionalTotal;
//         $totalCombinedBalance = $totalAcademicBalance + $totalProfessionalBalance;
//         $totalCombinedCollections = $totalCollectionsAcademics + $totalCollectionsProfessional;
//         $totalCombinedExpenses = $expensesAcademicTotal + $expensesProfessionalTotal;

//         $collectionsByCategoryAndMode = $feeCollectionTransactions->groupBy(['student_category', 'method_of_payment'])
//               ->map(fn($group) => $group->map(fn($items) => $items->sum(fn($item) => (float) $item->amount)));


//         $expensesByCategoryAndMode = $expensesTransactions->groupBy(['source_of_expense', 'mode_of_payment'])
//         ->map(fn($group) => $group->map(fn($items) => $items->sum(fn($item) => (float) $item->amount)));
          

//         $balanceByCategoryAndMode = [];
//         foreach (['Academic', 'Professional'] as $category) {
//             foreach (['Cash', 'Momo', 'Cheque'] as $mode) {
//                 $collections = $collectionsByCategoryAndMode[$category][$mode] ?? 0;
//                 $expenses = $expensesByCategoryAndMode[$category][$mode] ?? 0;
//                 $balanceByCategoryAndMode[$category][$mode] = $collections - $expenses;
//             }
//         }

//         // =======Opening Balance========
//         $currentDate = Carbon::parse($currentDate ?? Carbon::today())->toDateString();
//         $yesterday = Carbon::parse($currentDate)->subDay()->toDateString();
        
//         // ---- Opening Balance ----
//         $formFeesYesterday = DB::table('student_enquires')
//         ->whereDate('created_at', $yesterday)
//         ->where('bought_forms', 'Yes')
//         ->when($selectedCategory, fn($q) => $q->where('type_of_course', $selectedCategory), fn($q) => $q->whereIn('type_of_course', ['Academic', 'Professional']))
//         ->selectRaw('COALESCE(SUM(amount::numeric), 0) as total')
//         ->value('total');

//         $expensesYesterday = DB::table('expenses')
//             ->whereDate('created_at', $yesterday)
//             ->when(in_array($selectedCategory, ['Academic', 'Professional']),
//                 fn($q) => $q->where('source_of_expense', $selectedCategory),
//                 fn($q) => $q->whereIn('source_of_expense', ['Academic', 'Professional'])
//             )
//             ->when($modeOfPayment, fn($q) => $q->where('mode_of_payment', $modeOfPayment))
//             ->selectRaw('COALESCE(SUM(amount::numeric), 0) as total')
//             ->value('total');
        
//         $feeCollectionsYesterday = DB::table('collect_fees')
//         ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
//         ->whereDate('collect_fees.created_at', $yesterday)
//         ->when(in_array($selectedCategory, ['Academic', 'Professional']),
//             fn($q) => $q->where('students.student_category', $selectedCategory),
//             fn($q) => $q->whereIn('students.student_category', ['Academic', 'Professional'])
//         )
//         ->when(isset($paymentMethodMap[$modeOfPayment]), fn($q) => $q->where('collect_fees.method_of_payment', $paymentMethodMap[$modeOfPayment]))
//         ->selectRaw('COALESCE(SUM(collect_fees.amount::numeric), 0) as total')->value('total');

//         $lastBalance = 0;

//         $openingBalance = $lastBalance;

//         $closingBalance = ( $formFeesTotals + $feesPaymentsTotal + $openingBalance) - $expensesTotalAmount;

//         $openingBalance = $closingBalance;


//         // $openingBalance = ($formFeesYesterday + $feeCollectionsYesterday) - $expensesYesterday;




        



       
//         $data = [
//                     'selectedCategory' => $selectedCategory,
//                     'currentDate' => $currentDate,
//                     'startDate' => $startDate,
//                     'endDate' => $endDate,
//                     'expensesTransactions' => $expensesTransactions,
//                     'feeCollectionTransactions' => $feeCollectionTransactions,
//                     'feesTransactions' => $feesTransactions,
//                     'expensesAcademicTotal' => $expensesAcademicTotal,
//                     'totalCollectionsAcademics' => $totalCollectionsAcademics,
//                     'totalAcademicBalance' => $totalAcademicBalance,
//                     'expensesProfessionalTotal' => $expensesProfessionalTotal,
//                     'totalCollectionsProfessional' => $totalCollectionsProfessional,
//                     'totalProfessionalBalance' => $totalProfessionalBalance,
//                     'totalCombinedExpenses' => $totalCombinedExpenses,
//                     'totalCombinedCollections' => $totalCombinedCollections,
//                     'totalCombinedBalance' => $totalCombinedBalance,
//                     'formFeesTransactions' => $formFeesTransactions,
//                     'formFeesTotals' => $formFeesTotals,
//                     'formFeesBebelinos' => $formFeesBebelinos,
//                     'formFeesAllAmount' => $formFeesAllAmount,
//                     'feesPaymentsTotal' => $feesPaymentsTotal,
//                     'expensesTotalAmount' => $expensesTotalAmount,
//                     'collectionsByCategoryAndMode' => $collectionsByCategoryAndMode,
//                     'expensesByCategoryAndMode' => $expensesByCategoryAndMode,
//                     'balanceByCategoryAndMode' => $balanceByCategoryAndMode,
//                     'openingBalance' => $openingBalance,
//                     'closingBalance' => $closingBalance,
//                 ];

//         // return $data;

//         if ($selectedCategory === 'Academic') {
//             return view('backend.reports.getbalancereportacademic', $data);
//         } elseif ($selectedCategory === 'Professional') {
//             return view('backend.reports.getbalancereportprofessional', $data);
//         } elseif ($selectedCategory === 'Total') {
//             return view('backend.reports.getbalancereporttotal', $data);
//         }

//     } catch (Exception $e) {
//         Log::error('Error occurred while generating the balance report', [
//             'message' => $e->getMessage(),
//             'trace' => $e->getTraceAsString()
//         ]);
//         return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
//     }
// }

// public function calculateBalanceTotal(Request $request)
// {
//     try {
//         $validatedData = $request->validate([
//             'category' => 'nullable|string|in:Academic,Professional,Total',
//             'current_date' => 'nullable|date',
//             'start_date' => 'nullable|date',
//             'end_date' => 'nullable|date|after_or_equal:start_date',
//             'mode_of_payment' => 'nullable|string|in:Cash,Mobile Money,Bank Transfer',
//         ]);

//         $selectedCategory = $validatedData['category'] ?? null;
//         $currentDate = Carbon::parse($validatedData['current_date'] ?? Carbon::today())->toDateString();
//         $startDate = $validatedData['start_date'] ?? null;
//         $endDate = $validatedData['end_date'] ?? null;
//         $modeOfPayment = $validatedData['mode_of_payment'] ?? null;
//         $yesterday = Carbon::parse($currentDate)->subDay()->toDateString();

//         $paymentMethodMap = [
//             'Cash' => 'Cash',
//             'Mobile Money' => 'Momo',
//             'Bank Transfer' => 'Cheque'
//         ];

//         // ====== Opening Balance (from yesterday) ======
//         $formFeesYesterday = DB::table('student_enquires')
//             ->whereDate('created_at', $yesterday)
//             ->where('bought_forms', 'Yes')
//             ->when($selectedCategory, fn($q) => $q->where('type_of_course', $selectedCategory), fn($q) => $q->whereIn('type_of_course', ['Academic', 'Professional']))
//             ->sum(DB::raw('COALESCE(amount::numeric, 0)'));

//         $expensesYesterday = DB::table('expenses')
//             ->whereDate('created_at', $yesterday)
//             ->when(in_array($selectedCategory, ['Academic', 'Professional']),
//                 fn($q) => $q->where('source_of_expense', $selectedCategory),
//                 fn($q) => $q->whereIn('source_of_expense', ['Academic', 'Professional']))
//             ->when($modeOfPayment, fn($q) => $q->where('mode_of_payment', $modeOfPayment))
//             ->sum(DB::raw('COALESCE(amount::numeric, 0)'));

//         $feeCollectionsYesterday = DB::table('collect_fees')
//             ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
//             ->whereDate('collect_fees.created_at', $yesterday)
//             ->when(in_array($selectedCategory, ['Academic', 'Professional']),
//                 fn($q) => $q->where('students.student_category', $selectedCategory),
//                 fn($q) => $q->whereIn('students.student_category', ['Academic', 'Professional']))
//             ->when(isset($paymentMethodMap[$modeOfPayment]), fn($q) => $q->where('collect_fees.method_of_payment', $paymentMethodMap[$modeOfPayment]))
//             ->sum(DB::raw('COALESCE(collect_fees.amount::numeric, 0)'));

//         $openingBalance = ($formFeesYesterday + $feeCollectionsYesterday) - $expensesYesterday;

//         // ====== Form Fees for current range ======
//         $formFeesQuery = DB::table('student_enquires')
//             ->where('bought_forms', 'Yes')
//             ->when($currentDate, fn($q) => $q->whereDate('created_at', $currentDate))
//             ->when($startDate && $endDate, fn($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
//             ->when($selectedCategory, fn($q) => $q->where('type_of_course', $selectedCategory), fn($q) => $q->whereIn('type_of_course', ['Academic', 'Professional']));

//         $formFeesTransactions = $formFeesQuery->get();
//         $formFeesTotals = $formFeesTransactions->sum(fn($item) => (float) $item->amount);

//         // ====== Expenses ======
//         $expensesQuery = DB::table('expenses')
//             ->when(in_array($selectedCategory, ['Academic', 'Professional']),
//                 fn($q) => $q->where('source_of_expense', $selectedCategory),
//                 fn($q) => $q->whereIn('source_of_expense', ['Academic', 'Professional']))
//             ->when($modeOfPayment, fn($q) => $q->where('mode_of_payment', $modeOfPayment))
//             ->when($currentDate, fn($q) => $q->whereDate('created_at', $currentDate))
//             ->when($startDate && $endDate, fn($q) => $q->whereBetween('created_at', [$startDate, $endDate]));

//         $expensesTransactions = $expensesQuery->get();
//         $expensesTotalAmount = $expensesTransactions->sum(fn($item) => (float) $item->amount);

//         $expensesTotals = $expensesTransactions->groupBy('source_of_expense')
//             ->map(fn($items) => $items->sum(fn($item) => (float) $item->amount));

//         $expensesAcademicTotal = $expensesTotals['Academic'] ?? 0;
//         $expensesProfessionalTotal = $expensesTotals['Professional'] ?? 0;

//         // ====== Fee Collections ======
//         $feeCollectionsQuery = DB::table('collect_fees')
//             ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
//             ->whereIn('students.student_category', ['Academic', 'Professional'])
//             ->when($currentDate, fn($q) => $q->whereDate('collect_fees.created_at', $currentDate))
//             ->when($startDate && $endDate, fn($q) => $q->whereBetween('collect_fees.created_at', [$startDate, $endDate]))
//             ->when(isset($paymentMethodMap[$modeOfPayment]), fn($q) => $q->where('collect_fees.method_of_payment', $paymentMethodMap[$modeOfPayment]));

//         $feeCollectionTransactions = $feeCollectionsQuery->select('collect_fees.*', 'students.student_category')->get();
//         $feesPaymentsTotal = $feeCollectionTransactions->sum(fn($item) => (float) $item->amount);

//         $feesTransactions = in_array($selectedCategory, ['Academic', 'Professional']) 
//             ? $feeCollectionTransactions->where('student_category', $selectedCategory)->all()
//             : $feeCollectionTransactions;

//         $feeCollectionsTotals = $feeCollectionTransactions->groupBy('student_category')
//             ->map(fn($items) => $items->sum(fn($item) => (float) $item->amount));

//         $totalCollectionsAcademics = $feeCollectionsTotals['Academic'] ?? 0;
//         $totalCollectionsProfessional = $feeCollectionsTotals['Professional'] ?? 0;

//         $totalAcademicBalance = $totalCollectionsAcademics - $expensesAcademicTotal;
//         $totalProfessionalBalance = $totalCollectionsProfessional - $expensesProfessionalTotal;
//         $totalCombinedBalance = $totalAcademicBalance + $totalProfessionalBalance;
//         $totalCombinedCollections = $totalCollectionsAcademics + $totalCollectionsProfessional;
//         $totalCombinedExpenses = $expensesAcademicTotal + $expensesProfessionalTotal;

//         // ====== Closing Balance ======
//         $closingBalance = $openingBalance + $formFeesTotals + $feesPaymentsTotal - $expensesTotalAmount;

//         // ====== Mode breakdowns ======
//         $collectionsByCategoryAndMode = $feeCollectionTransactions->groupBy(['student_category', 'method_of_payment'])
//             ->map(fn($group) => $group->map(fn($items) => $items->sum(fn($item) => (float) $item->amount)));

//         $expensesByCategoryAndMode = $expensesTransactions->groupBy(['source_of_expense', 'mode_of_payment'])
//             ->map(fn($group) => $group->map(fn($items) => $items->sum(fn($item) => (float) $item->amount)));

//         $balanceByCategoryAndMode = [];
//         foreach (['Academic', 'Professional'] as $category) {
//             foreach (['Cash', 'Mobile Money', 'Bank Transfer'] as $mode) {
//                 $collections = $collectionsByCategoryAndMode[$category][$mode] ?? 0;
//                 $expenses = $expensesByCategoryAndMode[$category][$mode] ?? 0;
//                 $balanceByCategoryAndMode[$category][$mode] = $collections - $expenses;
//             }
//         }

//         $data = [
//             'selectedCategory' => $selectedCategory,
//             'currentDate' => $currentDate,
//             'startDate' => $startDate,
//             'endDate' => $endDate,
//             'expensesTransactions' => $expensesTransactions,
//             'feeCollectionTransactions' => $feeCollectionTransactions,
//             'feesTransactions' => $feesTransactions,
//             'expensesAcademicTotal' => $expensesAcademicTotal,
//             'totalCollectionsAcademics' => $totalCollectionsAcademics,
//             'totalAcademicBalance' => $totalAcademicBalance,
//             'expensesProfessionalTotal' => $expensesProfessionalTotal,
//             'totalCollectionsProfessional' => $totalCollectionsProfessional,
//             'totalProfessionalBalance' => $totalProfessionalBalance,
//             'totalCombinedExpenses' => $totalCombinedExpenses,
//             'totalCombinedCollections' => $totalCombinedCollections,
//             'totalCombinedBalance' => $totalCombinedBalance,
//             'formFeesTransactions' => $formFeesTransactions,
//             'formFeesTotals' => $formFeesTotals,
//             'feesPaymentsTotal' => $feesPaymentsTotal,
//             'expensesTotalAmount' => $expensesTotalAmount,
//             'collectionsByCategoryAndMode' => $collectionsByCategoryAndMode,
//             'expensesByCategoryAndMode' => $expensesByCategoryAndMode,
//             'balanceByCategoryAndMode' => $balanceByCategoryAndMode,
//             'openingBalance' => $openingBalance,
//             'closingBalance' => $closingBalance,
//         ];

//         if ($selectedCategory === 'Academic') {
//             return view('backend.reports.getbalancereportacademic', $data);
//         } elseif ($selectedCategory === 'Professional') {
//             return view('backend.reports.getbalancereportprofessional', $data);
//         } else {
//             return view('backend.reports.getbalancereporttotal', $data);
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
        'category' =>
        'nullable|string|in:Academic,Professional,Total',
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

        // If no date range is provided, use current date
        if (!$currentDate && !$startDate && !$endDate) {
            $currentDate = now()->format('Y-m-d');
        }

        // Determine the date range for daily calculations
        $dateRange = [];

        if ($currentDate) {
          $dateRange = [Carbon::parse($currentDate)];
        } elseif ($startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $dateRange = [];
            while ($start->lte($end)) {
            $dateRange[] = $start->copy();
            $start->addDay();
           }
        }

        // ========== CALCULATE DAILY BALANCES ==========
        $dailyBalances = [];

        $previousClosingBalance = $this->getPreviousClosingBalance($dateRange[0] ?? Carbon::now(),$selectedCategory, $modeOfPayment);

        foreach ($dateRange as $date) {
            $dailyData = $this->calculateDailyBalance($date,$selectedCategory, $modeOfPayment, $previousClosingBalance);
            $dailyBalances[$date->format('Y-m-d')] = $dailyData;
            $previousClosingBalance =$dailyData['closing_balance'];
        }
        // ========== ORIGINAL CALCULATIONS (for compatibility)
        // ========== FORM FEES ==========
        $formFeesQuery = DB::table('student_enquires');

        if ($currentDate) {
             $formFeesQuery->whereDate('created_at', $currentDate);
        } elseif ($startDate && $endDate) {
             $formFeesQuery->whereBetween('created_at', [$startDate,$endDate]);
        }

        $formFeesBebelinos = $formFeesQuery->where('bought_forms', 'Yes')->get();
        $formFeesAllAmount = $formFeesBebelinos->sum('amount');
        $formFeesTransactions = $formFeesQuery->where('bought_forms', 'Yes')
                                              ->when($selectedCategory, function ($query) use
        ($selectedCategory) {
        return $query->where('type_of_course',
        $selectedCategory);
        }, function ($query) {
        return $query->whereIn('type_of_course',
        ['Academic', 'Professional']);
        })->get();

        $formFeesTotals = $formFeesTransactions->sum('amount');
        // ========== EXPENSES ==========
        $expensesQuery = DB::table('expenses');

        if($selectedCategory === 'Academic' || $selectedCategory === 'Professional') {
           $expensesQuery->where('source_of_expense',$selectedCategory);
        } else {
            $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
        }

        if($modeOfPayment === 'Cash' || $modeOfPayment === 'Mobile Money' || $modeOfPayment === 'Bank Transfer') {
            $expensesQuery->where('mode_of_payment', $modeOfPayment);
        } else {
            $expensesQuery->whereIn('mode_of_payment',['Cash','Mobile Money','Bank Transfer']);
        }

        if ($currentDate) {
            $expensesQuery->whereDate('created_at', $currentDate);
        } elseif ($startDate && $endDate) {
            $expensesQuery->whereBetween('created_at', [$startDate,$endDate]);
        } elseif ($startDate) {
            $expensesQuery->where('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $expensesQuery->where('created_at', '<=', $endDate);
        }

        $expensesTransactions = $expensesQuery->get();
        // return $expensesTransactions;

        $expensesTotalAmount = $expensesTransactions->sum('amount');

        $expensesTotals = $expensesTransactions->groupBy('source_of_expense')->map(fn($items) => $items->sum('amount'));
       
        $expensesAcademicTotal = $expensesTotals['Academic'] ?? 0;
        
        $expensesProfessionalTotal = $expensesTotals['Professional'] ?? 0;

        // ========== SCHOOL FEES ==========
        $feeCollectionsQuery = DB::table('collect_fees')
        ->join('students', 'collect_fees.student_index_number',
        '=', 'students.index_number')
        ->whereIn('students.student_category', ['Academic','Professional']);

        $paymentMethodMap = [
        'Cash' => 'Cash',
        'Mobile Money' => 'Momo',
        'Bank Transfer' => 'Cheque'
        ];

        if (isset($paymentMethodMap[$modeOfPayment])) {
        $feeCollectionsQuery->where('method_of_payment',$paymentMethodMap[$modeOfPayment]);
        }

        if ($currentDate) {
        $feeCollectionsQuery->whereDate('collect_fees.created_at', $currentDate);
        } elseif ($startDate && $endDate) {
        $feeCollectionsQuery->whereBetween('collect_fees.created_at',[$startDate, $endDate]);
        } elseif ($startDate) {
        $feeCollectionsQuery->where('collect_fees.created_at','>=', $startDate);
        } elseif ($endDate) {
        $feeCollectionsQuery->where('collect_fees.created_at','<=', $endDate);
        }

        $feeCollectionTransactions = $feeCollectionsQuery
        ->select('collect_fees.*', 'students.student_category')
        ->get();

        $feesPaymentsTotal = $feeCollectionTransactions->sum('amount');

        $feesTransactions = in_array($selectedCategory,
        ['Academic', 'Professional'])
        ?
        $feeCollectionTransactions->where('student_category',
        $selectedCategory)->all() : $feeCollectionTransactions->whereIn('student_category',['Academic', 'Professional'])->all();
        $feeCollectionsTotals = $feeCollectionTransactions->groupBy('student_category') ->map(fn($items) => $items->sum('amount'));
        $totalCollectionsAcademics = $feeCollectionsTotals['Academic'] ?? 0;
        $totalCollectionsProfessional = $feeCollectionsTotals['Professional'] ?? 0;

        // ========== BALANCE PER CATEGORY ==========
        $totalAcademicBalance = $totalCollectionsAcademics -
        $expensesAcademicTotal;
        $totalProfessionalBalance = $totalCollectionsProfessional -
        $expensesProfessionalTotal;
        $totalCombinedBalance = $totalAcademicBalance +
        $totalProfessionalBalance;
        $totalCombinedCollections = $totalCollectionsAcademics +
        $totalCollectionsProfessional;
        $totalCombinedExpenses = $expensesAcademicTotal +
        $expensesProfessionalTotal;
        // ========== GROUPED BY CATEGORY + PAYMENT MODE ==========
        $collectionsByCategoryAndMode =
        $feeCollectionTransactions->groupBy(['student_category',
        'method_of_payment'])
        ->map(fn($categoryGroup) =>
        $categoryGroup->map(fn($items) =>
        $items->sum('amount'))
        );
        $expensesByCategoryAndMode =
        $expensesTransactions->groupBy(['source_of_expense',
        'mode_of_payment'])
        ->map(fn($categoryGroup) =>
        $categoryGroup->map(fn($items) =>
        $items->sum('amount'))
        );
        $balanceByCategoryAndMode = [];
        foreach (['Academic', 'Professional'] as $category) {
        foreach (['Cash', 'Momo', 'Cheque'] as $mode) {
        $collections =
        $collectionsByCategoryAndMode[$category][$mode] ?? 0;
        $expenses =
        $expensesByCategoryAndMode[$category][$mode] ?? 0;
        $balanceByCategoryAndMode[$category][$mode] =
        $collections - $expenses;
        }
        }
        // View Data
        $data = [
        'selectedCategory' => $selectedCategory,
        'currentDate' => $currentDate,
        'startDate' => $startDate,
        'endDate' => $endDate,
        // NEW: Daily balances data
        'dailyBalances' => $dailyBalances,
        'dateRange' => $dateRange,
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
        'totalCombinedCollections' =>$totalCombinedCollections,
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
        // return $data;
        // View response
        if ($selectedCategory === 'Academic') {
        return view('backend.reports.getbalancereportacademic',
        $data);
        } elseif ($selectedCategory === 'Professional') {
        return
        view('backend.reports.getbalancereportprofessional', $data);
        } elseif ($selectedCategory === 'Total') {
        return view('backend.reports.getbalancereporttotal',
        $data);
        }
        } catch (Exception $e) {
        Log::error('Error occurred while generating the balance
        report', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
        return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
    }
}
/**
* Calculate daily balance for a specific date
*/
private function calculateDailyBalance($date, $selectedCategory,
$modeOfPayment, $openingBalance)
{
$dateString = $date->format('Y-m-d');
// Get daily collections (income)
$dailyCollections = $this->getDailyCollections($dateString,
$selectedCategory, $modeOfPayment);
// Get daily expenses
$dailyExpenses = $this->getDailyExpenses($dateString,
$selectedCategory, $modeOfPayment);
// Get daily form fees
$dailyFormFees = $this->getDailyFormFees($dateString,
$selectedCategory);
// Calculate net transactions for the day
$totalDailyIncome = $dailyCollections + $dailyFormFees;
$netDailyTransaction = $totalDailyIncome - $dailyExpenses;
// Calculate closing balance
$closingBalance = $openingBalance + $netDailyTransaction;
return [
'date' => $dateString,
'opening_balance' => $openingBalance,
'daily_collections' => $dailyCollections,
'daily_expenses' => $dailyExpenses,
'daily_form_fees' => $dailyFormFees,
'total_daily_income' => $totalDailyIncome,
'net_daily_transaction' => $netDailyTransaction,
'closing_balance' => $closingBalance,
];
}
/**
* Get previous day's closing balance
*/
private function getPreviousClosingBalance($currentDate,
$selectedCategory, $modeOfPayment)
{
$previousDate = Carbon::parse($currentDate)->subDay();
// Get all transactions before the current date to calculate
// cumulative balance
$totalPreviousCollections =
$this->getTotalCollectionsBefore($previousDate, $selectedCategory,
$modeOfPayment);
$totalPreviousExpenses =
$this->getTotalExpensesBefore($previousDate, $selectedCategory,
$modeOfPayment);
$totalPreviousFormFees =
$this->getTotalFormFeesBefore($previousDate, $selectedCategory);
return ($totalPreviousCollections + $totalPreviousFormFees) -
$totalPreviousExpenses;
}
/**
* Get daily collections for a specific date
*/
private function getDailyCollections($date, $selectedCategory,
$modeOfPayment)
{
$query = DB::table('collect_fees')
->join('students', 'collect_fees.student_index_number',
'=', 'students.index_number')
->whereDate('collect_fees.created_at', $date);
// Apply category filter
if (in_array($selectedCategory, ['Academic', 'Professional']))
{
$query->where('students.student_category',
$selectedCategory);
} else {
$query->whereIn('students.student_category', ['Academic',
'Professional']);
}
// Apply payment method filter
$paymentMethodMap = [
'Cash' => 'Cash',
'Mobile Money' => 'Momo',
'Bank Transfer' => 'Cheque'
];
if (isset($paymentMethodMap[$modeOfPayment])) {
$query->where('method_of_payment',
$paymentMethodMap[$modeOfPayment]);
}
return $query->sum(DB::raw('CAST(collect_fees.amount AS
DECIMAL(10,2))')) ?? 0;
}
/**
* Get daily expenses for a specific date
*/
private function getDailyExpenses($date, $selectedCategory,
$modeOfPayment)
{
$query = DB::table('expenses')
->whereDate('created_at', $date);
// Apply category filter
if (in_array($selectedCategory, ['Academic', 'Professional']))
{
$query->where('source_of_expense', $selectedCategory);
} else {
$query->whereIn('source_of_expense', ['Academic',
'Professional']);
}
// Apply payment method filter
if (in_array($modeOfPayment, ['Cash', 'Mobile Money', 'Bank
Transfer'])) {
$query->where('mode_of_payment', $modeOfPayment);
}
return $query->sum(DB::raw('CAST(amount AS DECIMAL(10,2))')) ??
0;
}
/**
* Get daily form fees for a specific date
*/
private function getDailyFormFees($date, $selectedCategory)
{
$query = DB::table('student_enquires')
->whereDate('created_at', $date)
->where('bought_forms', 'Yes');
// Apply category filter
if (in_array($selectedCategory, ['Academic', 'Professional']))
{
$query->where('type_of_course', $selectedCategory);
} else {
$query->whereIn('type_of_course', ['Academic',
'Professional']);
}
return $query->sum(DB::raw('CAST(amount AS DECIMAL(10,2))')) ??
0;
}
/**
* Get total collections before a specific date
*/
private function getTotalCollectionsBefore($date,
$selectedCategory, $modeOfPayment)
{
$query = DB::table('collect_fees')
->join('students', 'collect_fees.student_index_number',
'=', 'students.index_number')
->where('collect_fees.created_at', '<=',
$date->endOfDay());
// Apply category filter
if (in_array($selectedCategory, ['Academic', 'Professional']))
{
$query->where('students.student_category',
$selectedCategory);
} else {
$query->whereIn('students.student_category', ['Academic',
'Professional']);
}
// Apply payment method filter
$paymentMethodMap = [
'Cash' => 'Cash',
'Mobile Money' => 'Momo',
'Bank Transfer' => 'Cheque'
];
if (isset($paymentMethodMap[$modeOfPayment])) {
$query->where('method_of_payment',
$paymentMethodMap[$modeOfPayment]);
}
return $query->sum(DB::raw('CAST(collect_fees.amount AS
DECIMAL(10,2))')) ?? 0;
}
/**
* Get total expenses before a specific date
*/
    private function getTotalExpensesBefore($date, $selectedCategory,$modeOfPayment)
    {
    $query = DB::table('expenses')
    ->where('created_at', '<=', $date->endOfDay());
    // Apply category filter
    if (in_array($selectedCategory, ['Academic', 'Professional']))
    {
    $query->where('source_of_expense', $selectedCategory);
    } else {
    $query->whereIn('source_of_expense', ['Academic',
    'Professional']);
    }
    // Apply payment method filter
    if (in_array($modeOfPayment, ['Cash', 'Mobile Money', 'Bank
    Transfer'])) {
    $query->where('mode_of_payment', $modeOfPayment);
    }
    return $query->sum(DB::raw('CAST(amount AS DECIMAL(10,2))')) ?? 0;
    }
/**
* Get total form fees before a specific date
*/
  private function getTotalFormFeesBefore($date, $selectedCategory)
    {
        $query = DB::table('student_enquires')
        ->where('created_at', '<=', $date->endOfDay())
        ->where('bought_forms', 'Yes');
        // Apply category filter
        if (in_array($selectedCategory, ['Academic', 'Professional']))
        {
        $query->where('type_of_course', $selectedCategory);
        } else {
        $query->whereIn('type_of_course', ['Academic',
        'Professional']);
        }
        return $query->sum(DB::raw('CAST(amount AS DECIMAL(10,2))')) ?? 0;
    }

}

