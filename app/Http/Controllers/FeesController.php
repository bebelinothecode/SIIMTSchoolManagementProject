<?php

namespace App\Http\Controllers;

use App\Fees;
use App\Level;
use App\Session;
use App\Student;
use App\FeesPaid;
use Exception;
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

        // $getStudentLevel = Studen

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
                'other_fees' => 'nullable'
            ]);

            // dd($validatedData);
            DB::beginTransaction();

            $student = Student::where('index_number',operator: $validatedData['student_index_number'])->first();

            if (!$student) {
                return back()->withErrors(['error' => 'Student not found.']);
            }

            $idempotencyKey = (string) Str::uuid();

            $existingPayment = FeesPaid::where('student_index_number', $validatedData['student_index_number'])
            ->where('student_name', $validatedData['student_name'])
            ->where('amount', $validatedData['fees_type'] === 'School Fees' ? $validatedData['amount'] : $validatedData['amount_paid'])
            ->where('method_of_payment', $validatedData['method_of_payment'])
            ->where('currency', $validatedData['currency'])
            ->where('fees_type', $validatedData['fees_type'])
            ->whereDate('created_at', now()->toDateString()) // same day check
            ->first();

            if ($existingPayment) {
                DB::rollBack();
                // return view('backend.fees.receipt', compact('existingPayment'))
                //     ->with('success', 'Payment already processed.');
                return redirect()->back()->with("success","Payment already processed.");
            }

            $receipt_number = "RCPT-".date('Y-m-d')."-".strtoupper(Str::random(8)); 

            $feespaid = FeesPaid::create([
                'student_index_number' => $validatedData['student_index_number'],
                'student_name' => $validatedData['student_name'],
                'method_of_payment' => $validatedData['method_of_payment'],
                'amount' => $validatedData['fees_type'] === 'School Fees' ? $validatedData['amount'] : $validatedData['amount_paid'],
                'balance' => $validatedData['fees_type'] === 'School Fees' ? $validatedData['balance'] : 0,
                'currency' => $validatedData['currency'],
                'Momo_number' => $validatedData['Momo_number'],
                'cheque_number' => $validatedData['cheque_number'],
                'remarks' => $validatedData['remarks'],
                'receipt_number' => $receipt_number,
                'fees_type' => $validatedData['fees_type'],
                'other_fees' => $validatedData['other_fees'],
                'idempotency_key' => $idempotencyKey
            ]);

            if($feespaid) {
                $student->balance = $validatedData['balance'];
                $student->save();                                                              
                Log::info('Balance saved successfully');
            }

            DB::commit();

            return view('backend.fees.receipt', compact('feespaid'))->with('success', 'School Fees has been collected');
        } catch (Exception $e) {
            //throw $th;
            DB::rollBack();
            
            Log::info('Request Data', $request->all());

            Log::error('Error collecting fees: ' . $e);

            return back()->withInput()->withErrors(['error' => 'An error occurred while collecting the students fees. Please try again.']);
        }
    }

    public function selectdefaulters(Request $request) {
        $sort = $request->input('sort');

        $query = Student::with('user', 'course', 'diploma')->where('balance', '>', 0);

        if($request->has('search') && $request->search != "") {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name','like','%'.$request->search .'%');
            })->orWhere('index_number', 'like', '%' . $request->search . '%');
        }

        if($sort === 'Academic' || $sort === 'Professional') {
            $query->where('student_category', $sort);
        }

        $defaulters = $query->orderBy('balance', 'desc')->paginate(10);

        $defaultersAcademicTotal = Student::where('balance', '>', 0)->where('student_category', 'Academic')->sum(DB::raw('CAST(balance AS DECIMAL(10,2))'));

        $defaultersAcademicProfessional = Student::where('balance', '>', 0)->where('student_category','Professional')->sum(DB::raw('CAST(balance AS DECIMAL(10,2))'));

        $totalAmount = $defaultersAcademicTotal + $defaultersAcademicProfessional;

        return view('backend.fees.defaulters', compact('defaulters','defaultersAcademicTotal','defaultersAcademicProfessional','totalAmount'));
    }

        

    public function studentFees(Request $request) {
        $request = $request->all();

        return $request;
    }

    public function feesHistory() {
        try {
            //code...
            $userId = Auth::id();
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            $user = Auth::user();

            $student = DB::table('students')
                ->where('user_id', $userId)
                ->first();

            if (!$student) {
                throw new Exception('Student record not found');
            }

            // $payments = DB::table('collect_fees')->where('student_index_number',operator: $student->index_number)->get();
            $payments = DB::table('collect_fees')->where('student_index_number', $student->index_number)->orderBy('created_at', 'desc')->paginate(10);
            return view('backend.students.paymenthistory', compact('payments','student','user'));
        } catch (\Throwable $e) {
             Log::error('Error in getCourseOutlineForm: ' . $e->getMessage());
            
             // Redirect back with error message
             return redirect()->back()->with('error', 'Failed to load course outline: ' . $e->getMessage());
        }

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
            $search = $request->input('search');
    
            $query = FeesPaid::query();
    
            if (!empty($search)) {
                $query->where('student_index_number', 'like', "%{$search}%")
                      ->orWhere('student_name', 'like', "%{$search}%");
            }
    
            $transactions = $query->latest()->paginate(15);

            // return $transactions;
    
            return view('backend.fees.transactions', compact('transactions'));
        } catch (Exception $e) {
            Log::error("Error executing query", ["message" => $e->getMessage()]);
            
            return redirect()->back()->with('error', 'An error occurred while fetching transactions.');
        }
    }
    

    public function editTransactionForm($id) {
        $transaction = FeesPaid::findOrFail($id);

        $student = Student::where('index_number',$transaction->student_index_number)->get();

        $balance = $student->first()->balance;

        // return $balance;

        return view('backend.fees.edittransactionform', compact('transaction','balance'));
    }

    public function updateTransaction(Request $request, $id) {

        try {
            $validatedData = $request->validate([
                'student_name' => 'required',
                'student_index_number' => 'required',
                'method_of_payment' => 'required',
                'amount' => 'required',
                'balance' => 'required',
                'currency' => 'required',
                'cheque_number' => 'nullable',
                'Momo_number' => 'nullable',
                'remarks' => 'nullable',
                'receipt_number' => 'nullable',
                'fees_type' => 'required',
            ]);
    
            $transaction = FeesPaid::findOrFail($id);
    
            $transaction->update($validatedData);
    
            return redirect()->back()->with("success","School Fees has been set successfully");
        } catch (Exception $e) {
            Log::error('Error updating transaction:'. $e);
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

    public function deleteTransaction($id) {
        try {
            //code...
            $transaction = FeesPaid::findOrFail($id);

            $transaction->delete();

            return redirect()->back()->with('success','Transaction deleted successfully');
        } catch (\Exception $e) {
            //throw $th;
            Log::error('Error deleting diploma',[$e->getMessage()]);

            return redirect()->back()->with('error','Error deleting transaction');
        }
       
    }

    public function printReceiptFromTransaction($id) {
        try {
            //code...
            $transaction = FeesPaid::findOrFail($id);

            return view('backend.fees.transactionreceipt', compact('transaction'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error','Error generating receipt');
        }
    }
}


