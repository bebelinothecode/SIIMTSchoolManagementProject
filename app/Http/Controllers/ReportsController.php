<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use Exception;
use App\Diploma;
use App\Student;
use App\Subject;
use App\Teacher;
use App\FeesPaid;
use App\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Validation\Validator;
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

    public function generatePaymentReport(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'current_date' => 'nullable|date',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            // If validation fails, redirect back with errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Get input values
            $currentDate = $request->input('current_date');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Initialize the query
            $query = FeesPaid::query();

            // Apply filters based on input
            if ($currentDate) {
                $query->whereDate('created_at', $currentDate);
            }

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Fetch the results
            $payments = $query->get();

            // return $payments;

            // Return the results to a view (or as JSON)
            return view('backend.reports.paymentreport', compact('payments','currentDate','startDate','endDate')); // Replace 'payment_report' with your view name
        } catch (Exception $e) {
            // Log the error
            Log::error('Error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            // Redirect back with an error message
            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again.');
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
}
