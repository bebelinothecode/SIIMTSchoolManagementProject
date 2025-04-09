<?php

namespace App\Http\Controllers;

use App\Fees;
use App\Level;
use App\Session;
use App\Student;
use App\FeesPaid;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class  FeesController extends Controller
{
    public function show() {
        $sessions = Session::all();

        return view('backend.fees.show', compact('sessions'));
    }

    public function  create(Request $request) {

    $validatedData = $request->validate([
        'school_fees' => 'required|integer',
        'currency' => 'required',
        'session' => 'required',
        'student_type' => 'required',
        'start_academic_year' => 'required',
        'end_academic_year' => 'required'
    ]);

    Fees::create($validatedData);

    return redirect()->back()->with("success","School Fees has been set successfully");
    }

    public function showcollectfees() {
        $sessions = Session::all();
        
        $levels = Level::all();

        $fees = Fees::all();

        $details = Student::with('user')->latest()->get();

        return view('backend.fees.collect', compact('sessions','details','fees','levels'));
    }

    public function getStudentName(Request $request) {
        $indexNumber = $request->input('index_number');

        $student = Student::with('user')->where('index_number', $indexNumber)->first();

        if($student) {
            return response()->json([
                'name'=> $student->user->name,
                'fees' => $student->fees,
                'student_category' => $student->student_category,
                'fees_prof' => $student->fees_prof,
                'currency' => $student->currency,
                'currency_prof' => $student->currency_prof,
                'balance' => $student->balance,
            ]);
        } else {
            return response()->json(['name'=>null], 404);
        }
    }

    public function collectfees(Request $request) {
        try {
            // dd($request->all());
            $validatedData = $request->validate([
                'student_index_number' => 'required|string',
                'student_name' => 'required | string',
                'method_of_payment' => 'required',
                'fees_type' => 'required',
                'amount' => 'nullable',
                'amount_paid' => 'nullable',
                'balance' => 'nullable',
                'currency' => 'required',
                'Momo_number' => 'nullable',
                'cheque_number' => 'nullable',
                'remarks'  => 'nullable|string',
            ]);

            // dd($validatedData);

            $student = Student::where('index_number',$validatedData['student_index_number'])->first();

            $receipt_number = "RCPT-".date('Y-m-d')."-".strtoupper(Str::random(8)); 

            DB::beginTransaction();

            if ($validatedData['fees_type'] === 'School Fees') {
                $feespaid = FeesPaid::create([
                    'student_index_number' => $validatedData['student_index_number'],
                    'student_name' => $validatedData['student_name'],
                    'method_of_payment' => $validatedData['method_of_payment'],
                    'amount' => $validatedData['amount'],
                    'balance' => $validatedData['balance'],
                    'currency' => $validatedData['currency'],
                    'Momo_number' => $validatedData['Momo_number'],
                    'cheque_number' => $validatedData['cheque_number'],
                    'remarks' => $validatedData['remarks'],
                    'receipt_number' => $receipt_number,
                    'fees_type' => $validatedData['fees_type']
                ]);
            } else {
                $feespaid = FeesPaid::create([
                    'student_index_number' => $validatedData['student_index_number'],
                    'student_name' => $validatedData['student_name'],
                    'method_of_payment' => $validatedData['method_of_payment'],
                    'amount' => $validatedData['amount_paid'],
                    'balance' => 0,
                    'currency' => $validatedData['currency'],
                    'Momo_number' => $validatedData['Momo_number'],
                    'cheque_number' => $validatedData['cheque_number'],
                    'remarks' => $validatedData['remarks'],
                    'receipt_number' => $receipt_number,
                    'fees_type' => $validatedData['fees_type']
                ]);
            }
            // dd($feespaid);

            if($feespaid) {
                $student->balance = $validatedData['balance'];
                $student->save();                                                              
                Log::info('Balance saved successfully');
            }

            DB::commit();

            return view('backend.fees.receipt', compact('feespaid'))->with('success', 'School Fees has been collected');
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            
            Log::info('Request Data', $request->all());

            Log::error('Error collecting fees: ' . $e);

            return back()->withInput()->withErrors(['error' => 'An error occurred while collecting the students fees. Please try again.']);
        }
    }

    // public function  selectdefaulters() {
    //     $defaulters = Student::with('user','course','diploma')
    //     ->where('balance', '>', 0)
    //     ->orderBy('balance', 'desc')
    //     ->paginate(10);

    //     // return $defaulters;

    //     return view('backend.fees.defaulters', compact('defaulters'));
    // }

    public function selectdefaulters(Request $request) 
    {
        $query = Student::with('user', 'course', 'diploma')
            ->where('balance', '>', 0);
        
        // Add search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                            // ->orWhere('email', 'like', '%' . $search . '%');
                })
                // ->orWhereHas('course', function($courseQuery) use ($search) {
                //     $courseQuery->where('name', 'like', '%' . $search . '%');
                // })
                // ->orWhereHas('diploma', function($diplomaQuery) use ($search) {
                //     $diplomaQuery->where('name', 'like', '%' . $search . '%');
                // })
                ->orWhere('index_number', 'like', '%' . $search . '%');
            });
        }

        $defaulters = $query->orderBy('balance', 'desc')->paginate(10);

        // dd($defaulters);
        
        return view('backend.fees.defaulters', compact('defaulters'));
    }

    public function studentFees(Request $request) {
        $request = $request->all();

        return $request;
    }

    public function feesHistory() {
        $sessions = Session::all();

        return view('backend.students.paymenthistory', compact('sessions'));
    }


    public function getFeeHistory(Request $request, User $user) {
        $start_academic_year = $request->start_academic_year;
        $end_academic_year = $request->end_academic_year;
        $semester = $request->semester;
        $user = Auth::user();
        $indexNumber = $user->student->index_number;

        $records = DB::table('collect_fees')
        ->where('student_index_number', $indexNumber)
        ->where('semester', $semester)
        ->whereBetween('start_academic_year', [$start_academic_year, $end_academic_year])
        ->get();

        return view('backend.students.paymenthistory', [
            'records' => $records,
            'sessions' => Session::all(), // Pass sessions for the dropdown
        ]);
    }

    public function transactionsForm() {
        return view('backend.fees.transactions');
    }

    public function getTransactions(Request $request) {
        try {
            //code...
            $request->all([
                'start_date' => 'required|date',
                'end_date' => 'required|date'
            ]);
            
            $query = FeesPaid::query();
            
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('created_at', [
                    $request->start_date,
                    $request->end_date
                ]);
            }

            $transactions = $query->latest()->paginate(10);

            return view('backend.fees.transactions', compact('transactions'));
        } catch (\Exception $e) {
            //throw $th;
            Log::error("Error executing query",["Error exceuting code"=>$e->getMessage()]);
        }
    }

    public function test(Request $request) {
        $query = 'Cam $ Mase';


        $books = DB::table('pdf')
               ->where('isbn_number', 'LIKE', "%{$query}%")
               ->orWhere('author', 'LIKE', "%{$query}%")
               ->orWhere('title', 'LIKE', "%{$query}%")
               ->get();

        return response()->json($books);
    }
}


