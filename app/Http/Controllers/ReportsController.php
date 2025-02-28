<?php

namespace App\Http\Controllers;

use App\Grade;
use Exception;
use App\Diploma;
use App\Student;
use App\Subject;
use App\Teacher;
use App\FeesPaid;
use App\AcademicYear;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
    public function getReportsForm(Request $request) {
        // Fetch students and handle search
        // $query = Student::with('user', 'course', 'diploma')
        //     ->where(function ($q) {
        //         $q->whereNotNull('course_id')
        //         ->orWhereNotNull('course_id_prof');
        //     });

        // if ($request->has('search') && $request->search != '') {
        //     $query->whereHas('user', function ($q) use ($request) {
        //         $q->where('name', 'like', '%' . $request->search . '%')
        //         ->orWhere('email', 'like', '%' . $request->search . '%');
        //     })
        //     ->orWhere('index_number', 'like', '%' . $request-]>search . '%');
        // }

        // $students = $query->latest()->paginate(10); // Adjust pagination size as needed
        $diplomas = Diploma::all();

        return view('backend.reports.students', compact('diplomas'));
    }

    public function example() {
        $teachers = Teacher::with(['user', 'subjects'])->latest()->paginate(10);

        return $teachers;
    }

    public function getPaymentReportForm() {
        return view('backend.reports.paymentform');
    }

    public function generate(Request $request) {
        try {
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

        
        
        // return $students;

        // Pass data to the report view
        return view('backend.reports.studentreport', compact('students', 'startDate', 'endDate','diplomaID'));
            
        } catch (Exception $e) {
            //throw $th;
        Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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

    // public function generatePaymentReport(Request $request)
    // {
    //     try {
    //         // dd($request->all());
    //         $validatedData = $request->validate([
    //             'current_date' => 'nullable|date',
    //             'start_date' => 'nullable|date',
    //             'end_date' => 'nullable|date',
    //             'aca_prof' => 'nullable|in:Academic,Professional'
    //         ]);

    //         $currentDate = $validatedData['current_date'];
    //         $startDate = $validatedData['start_date'];
    //         $endDate = $validatedData['end_date'];
    //         $aca_prof = $validatedData['aca_prof'];


    //         // Initialize the query
    //         $query = FeesPaid::query();

    //         // Apply filters based on input
    //         if ($validatedData['current_date']) {
    //             $query->whereDate('created_at', $validatedData['current_date']);
    //         }

    //         if ($validatedData['start_date'] && $validatedData['end_date']) {
    //             $query->whereBetween('created_at', [$validatedData['start_date'], $validatedData['start_date']]);
    //         }

    //         // Fetch the results
    //         $payments = $query->get();

    //         // return $payments;

    //         // Return the results to a view (or as JSON)
    //         return view('backend.reports.paymentreport', compact('payments','currentDate','startDate','endDate','aca_prof')); // Replace 'payment_report' with your view name
    //     } catch (Exception $e) {
    //         // Log the error
    //         Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

    //         // Redirect back with an error message
    //         return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
    //     }
    // }

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
            //code...
            $validatedData = $request->validate([
                'current_date' => 'nullable|date',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'aca_prof' => 'nullable|in:Academic,Professional'
            ]);
    
            $currentDate = $validatedData['current_date'];
            $startDate = $validatedData['start_date'];
            $endDate = $validatedData['end_date'];
            $aca_prof = $validatedData['aca_prof'];
    
        // Step 1: Get unique student index numbers from the collect_fees table
        $uniqueIndexNumbers = FeesPaid::distinct()->pluck('student_index_number');
    
        // Step 2: Fetch student categories for the unique index numbers
        $students = Student::whereIn('index_number', $uniqueIndexNumbers)
            ->pluck('student_category', 'index_number');
    
        // Step 3: Fetch all fee transactions with optional filters
        $feeTransactionsQuery = FeesPaid::whereIn('student_index_number', $uniqueIndexNumbers);
    
        // Apply date range filter if provided
        if ($startDate && $endDate) {
            $feeTransactionsQuery->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $feeTransactionsQuery->where('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $feeTransactionsQuery->where('created_at', '<=', $endDate);
        } elseif($currentDate) {
            $feeTransactionsQuery->whereDate('created_at',$currentDate);
        }
    
        // Apply category filter if provided
        if ($aca_prof) {
            $filteredIndexNumbers = $students->filter(function ($category) use ($aca_prof) {
                return strtolower($category) === strtolower($aca_prof);
            })->keys();
    
            $feeTransactionsQuery->whereIn('student_index_number', $filteredIndexNumbers);
        }
    
        $feeTransactions = $feeTransactionsQuery->get();
    
        // Step 4: Group transactions by student category and currency
        $transactionsByCategoryAndCurrency = [
            'academic' => [],
            'professional' => []
        ];
    
        foreach ($feeTransactions as $transaction) {
            $indexNumber = $transaction->student_index_number;
            $category = strtolower($students[$indexNumber] ?? 'unknown'); // Default to 'unknown' if category not found
            $currency = $transaction->currency;
    
            if (array_key_exists($category, $transactionsByCategoryAndCurrency)) {
                if (!isset($transactionsByCategoryAndCurrency[$category][$currency])) {
                    $transactionsByCategoryAndCurrency[$category][$currency] = [];
                }
                $transactionsByCategoryAndCurrency[$category][$currency][] = $transaction;
            }
        }
    
        // Step 5: Calculate totals for each category and currency
        $totalsByCategoryAndCurrency = [
            'academic' => [],
            'professional' => []
        ];
    
        foreach ($transactionsByCategoryAndCurrency as $category => $currencies) {
            foreach ($currencies as $currency => $transactions) {
                $totalsByCategoryAndCurrency[$category][$currency] = collect($transactions)->sum('amount');
            }
        }
    
        // Step 6: Prepare the response
        $response = [
            'transactions_by_category_and_currency' => $transactionsByCategoryAndCurrency,
            'totals_by_category_and_currency' => $totalsByCategoryAndCurrency
        ];

    
        // return $response;
        return view('backend.reports.paymentreport', compact('transactionsByCategoryAndCurrency','currentDate','startDate','endDate','aca_prof','totalsByCategoryAndCurrency')); // Replace 'payment_report' with your view name
        } catch (\Exception $e) {
            //throw $th;
            Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
        }
    }

    public function getBalanceForm() {
        return view('backend.reports.getbalanceform');
    }

    // public function calculateBalanceTotal(Request $request) {
    //     try {
    //         // dd($request->all());
    //         $validatedData = $request->validate([
    //             'category' => 'required|string',
    //             'current_month' => 'nullable|date_format:Y-m',
    //             'start_date' => 'nullable|date',
    //             'end_date' => 'nullable|date'
    //         ]);

    //         $selectedCategory = $validatedData['category'];
    //         $currentMonth = $validatedData['current_month'];
    //         $startDate = $validatedData['start_date'];
    //         $endDate = $validatedData['end_date'];

    //         $expensesAcademicTotal = DB::table('expenses')
    //                 ->where('source_of_expense', 'Academic')
    //                 ->sum('amount');
            
    //         $expensesProfessionalTotal = DB::table('expenses')
    //         ->where('source_of_expense', 'Professional')
    //         ->sum('amount');

    //         $totals = DB::table('collect_fees')
    //         ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
    //         ->select('students.student_category', DB::raw('SUM(collect_fees.amount) as total'))
    //         ->whereIn('students.student_category', ['Academic','Professional'])
    //         ->groupBy('students.student_category')
    //         ->get();

    //         $totals = $totals->pluck('total', 'student_category');

    //         $totalCollectionsAcademic = $totals['Academic'] ?? 0;

    //         $totalCollectionsProfessional = $totals['Professional'] ?? 0;


    //         // return $totals['Academic'] ?? 0;

    //         // return [
    //         //     'academic_total' => $totals['Academic'] ?? 0,
    //         //     'professional_total' => $totals['Professional'] ?? 0,
    //         // ];

    //         if ($selectedCategory === "Academic" || $selectedCategory === 'Professional') {
    //             if ($selectedCategory === 'Academic') {
    //                 $totalAcademicBalance = $totalCollectionsAcademic - $expensesAcademicTotal;
    //                 return view('backend.reports.getbalancereportacademic', compact('totalAcademicBalance','totalCollectionsAcademic','expensesAcademicTotal','selectedCategory'));
    //             } elseif ($selectedCategory === 'Professional') {
    //                 $totalProfessionalBalance = $totalCollectionsProfessional - $expensesProfessionalTotal;

    //                 return view('backend.reports.getbalancereportprofessional',compact('selectedCategory','totalProfessionalBalance','totalCollectionsProfessional','expensesProfessionalTotal'));
    //             }
    //         }

    //     } catch (\Exception $e) {
    //         //throw $th;
    //         Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    //     }

    // }

    // public function calculateBalanceTotal(Request $request) {
    //     try {
    //         // Validate the request data
    //         $validatedData = $request->validate([
    //             'category' => 'nullable|string',
    //             'current_month' => 'nullable|date_format:Y-m',
    //             'start_date' => 'nullable|date',
    //             'end_date' => 'nullable|date'
    //         ]);
    
    //         $selectedCategory = $validatedData['category'];
    //         $currentMonth = $validatedData['current_month'];
    //         $startDate = $validatedData['start_date'];
    //         $endDate = $validatedData['end_date'];
    
    //         // Calculate expenses totals
    //         $expensesAcademicTotal = DB::table('expenses')
    //             ->where('source_of_expense', 'Academic')
    //             ->sum('amount');
    
    //         $expensesProfessionalTotal = DB::table('expenses')
    //             ->where('source_of_expense', 'Professional')
    //             ->sum('amount');
    
    //         // Query for fee collections with date filters
    //         $feeCollectionsQuery = DB::table('collect_fees')
    //             ->join('students', 'collect_fees.student_index_number', '=', 'students.index_number')
    //             ->select('students.student_category', DB::raw('SUM(collect_fees.amount) as total'))
    //             ->whereIn('students.student_category', ['Academic', 'Professional']);
    
    //         // Apply current month filter
    //         if ($currentMonth) {
    //             $feeCollectionsQuery->whereYear('collect_fees.created_at', '=', date('Y', strtotime($currentMonth)))
    //                                 ->whereMonth('collect_fees.created_at', '=', date('m', strtotime($currentMonth)));
    //         }
    
    //         // Apply date range filter
    //         if ($startDate && $endDate) {
    //             $feeCollectionsQuery->whereBetween('collect_fees.created_at', [$startDate, $endDate]);
    //         } elseif ($startDate) {
    //             $feeCollectionsQuery->where('collect_fees.created_at', '>=', $startDate);
    //         } elseif ($endDate) {
    //             $feeCollectionsQuery->where('collect_fees.created_at', '<=', $endDate);
    //         }
    
    //         // Group by category and get totals
    //         $totals = $feeCollectionsQuery->groupBy('students.student_category')->get();
    
    //         // Convert the result to an associative array for easier access
    //         $totals = $totals->pluck('total', 'student_category');
    
    //         $totalCollectionsAcademic = $totals['Academic'] ?? 0;
    //         $totalCollectionsProfessional = $totals['Professional'] ?? 0;
    
    //         // Calculate balance based on selected category
    //         if ($selectedCategory) {
    //             if ($selectedCategory === 'Academic') {
    //                 $totalAcademicBalance = $totalCollectionsAcademic - $expensesAcademicTotal;
    //                 return view('backend.reports.getbalancereportacademic', compact('totalAcademicBalance', 'totalCollectionsAcademic', 'expensesAcademicTotal', 'selectedCategory'));
    //             } elseif ($selectedCategory === 'Professional') {
    //                 $totalProfessionalBalance = $totalCollectionsProfessional - $expensesProfessionalTotal;
    //                 return view('backend.reports.getbalancereportprofessional', compact('selectedCategory', 'totalProfessionalBalance', 'totalCollectionsProfessional', 'expensesProfessionalTotal'));
    //             }
    //         }
    
    //     } catch (\Exception $e) {
    //         // Log the error
    //         Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

    //         return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
    //     }
    // }

    public function calculateBalanceTotal(Request $request) {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'category' => 'nullable|string|in:Academic,Professional',
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
    
            // Apply category filter
            if ($selectedCategory) {
                $expensesQuery->where('source_of_expense', $selectedCategory);
            } else {
                $expensesQuery->whereIn('source_of_expense', ['Academic', 'Professional']);
            }
    
            // Apply date filters
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
    
            // Get expense totals
            // $expensesTotals = $expensesQuery->selectRaw("
            //     SUM(CASE WHEN source_of_expense = 'Academic' THEN amount ELSE 0 END) as expensesAcademicTotal,
            //     SUM(CASE WHEN source_of_expense = 'Professional' THEN amount ELSE 0 END) as expensesProfessionalTotal
            // ")->first();

             // Calculate expenses totals
            $expensesAcademicTotal = DB::table('expenses')
                ->where('source_of_expense', 'Academic')
                ->sum('amount');
    
            $expensesProfessionalTotal = DB::table('expenses')
                ->where('source_of_expense', 'Professional')
                ->sum('amount');

            // return $expensesTotals;
    
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
            $totalAcademicBalance = $totalCollectionsAcademic - ($expensesAcademicTotal ?? 0);
            $totalProfessionalBalance = $totalCollectionsProfessional - ($expensesProfessionalTotal ?? 0);
    
            // Determine which view to return
            if ($selectedCategory === 'Academic') {
                return view('backend.reports.getbalancereportacademic', compact(
                    'totalAcademicBalance', 'totalCollectionsAcademic', 'expensesAcademicTotal', 'selectedCategory'
                ));
            } elseif ($selectedCategory === 'Professional') {
                return view('backend.reports.getbalancereportprofessional', compact(
                    'totalProfessionalBalance', 'totalCollectionsProfessional', 'expensesProfessionalTotal', 'selectedCategory'
                ));
            }
    
            return redirect()->back()->with('error', 'Invalid category selection.');
    
        } catch (\Exception $e) {
            Log::error('Error occurred while generating the balance report', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
        }
    }
    
}
