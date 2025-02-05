<?php

namespace App\Http\Controllers;

use App\Fees;
use App\Level;
use App\Session;
use App\Student;
use App\FeesPaid;
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
                'amount' => 'required',
                'balance' => 'required',
                'currency' => 'required',
                'Momo_number' => 'nullable',
                'cheque_number' => 'nullable',
            ]);

            // dd($validatedData);

            $student = Student::where('index_number',$validatedData['student_index_number'])->first();

            // $remainingBalance = $student->balance - $validatedData['amount'];

            // $student->balance = $validatedData['balance'];
            // $student->save();

            $feespaid = FeesPaid::create([
                'student_index_number' => $validatedData['student_index_number'],
                'student_name' => $validatedData['student_name'],
                'method_of_payment' => $validatedData['method_of_payment'],
                'amount' => $validatedData['amount'],
                'balance' => $validatedData['balance'],
                'currency' => $validatedData['currency'],
                'Momo_number' => $validatedData['Momo_number'],
                'cheque_number' => $validatedData['cheque_number']
            ]);

            if($feespaid) {
                $student->balance = $validatedData['balance'];
                $student->save();
                Log::info('Balance saved successfully');
            }

            return view('backend.fees.receipt', compact('feespaid'))->with('success', 'School Fees has been collected');
        } catch (\Exception $e) {
            //throw $th;
            Log::info('Request Data', $request->all());

            Log::error('Error creating student: ' . $e);

            return back()->withInput()->withErrors(['error' => 'An error occurred while creating the student. Please try again.']);
        }
    }

    public function selectdefaulters() {
        // $sessions = Session::all();

        $defaulters = Student::with('user')
        ->where('balance', '>', 0)
        ->orderBy('balance', 'desc')
        ->paginate(10);

        return view('backend.fees.defaulters', compact('defaulters'));
    }

    // public function getdefaulters() {
    //     // $start_academic_year = $request->start_academic_year;
    //     // $end_academic_year = $request->end_academic_year;
    //     // $semester = $request->semester;

    //     // $defaulters = FeesPaid::select('student_index_number', 'student_name','balance','currency')
    //     // ->where('start_academic_year', $start_academic_year)
    //     // ->where('end_academic_year', $end_academic_year)
    //     // ->where('semester', $semester)
    //     // ->where('balance', '>', 0)
    //     // ->groupBy('student_index_number', 'student_name','balance','currency')
    //     // ->get();

    //     $defaulters = Student::with('user')
    //                  ->where('balance', '>', 0)
    //                  ->orderBy('balance', 'desc')
    //                  ->paginate(10);
        
    //     return view('backend.fees.defaulters', compact('defaulters'));
    
    //     // return $defaulters;

    //     // return view('backend.fees.defaulters', [
    //     //     'defaulters' => $defaulters,
    //     //     'sessions' => Session::all(), // Pass sessions for the dropdown
    //     // ]);
    // }

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


