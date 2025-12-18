<?php

namespace App\Http\Controllers;

use App\Diploma;
use App\Subject;
use App\User;
use App\Teacher;
use App\TeacherSubject;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\TeacherSalaryCalculator;

class TeacherController extends Controller
{
    private $salaryService;

    public function __construct(TeacherSalaryCalculator $salaryService)
    {
        $this->salaryService = $salaryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::with('user','subjects')->latest()->paginate(5);

        // return $teachers;

        return view('backend.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:8',
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        // dd($validatedData);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);
        
        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($user->name).'-'.$user->id.'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = 'avatar.png';
        }
        $user->update([
            'profile_picture' => $profile
        ]);

        $user->teacher()->create([
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        $user->assignRole('Teacher');

        return redirect()->back()->with('success', 'Teacher created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // dd($request->all());
        // $validatedData = $request->validate([
        //     'teacher_id' => 'required|exists:teachers,id'
        // ]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $teacher = Teacher::with('user')->findOrFail($teacher->id);

        return view('backend.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email,'.$teacher->user_id,
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        $user = User::findOrFail($teacher->user_id);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($user->name).'-'.$user->id.'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = $user->profile_picture;
        }

        $user->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'profile_picture'   => $profile
        ]);

        $user->teacher()->update([
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        return redirect()->back()->with('success', 'Teacher created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $user = User::findOrFail($teacher->user_id);

        $user->teacher()->delete();
        
        $user->removeRole('Teacher');

        if ($user->delete()) {
            if($user->profile_picture != 'avatar.png') {
                $image_path = public_path() . '/images/profile/' . $user->profile_picture;
                if (is_file($image_path) && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        return back();
    }

    public function profile($id) {
        $teacher = Teacher::with(['user', 'subjects'])->findOrFail($id);

        return view('backend.teachers.profile', compact('teacher'));
    }

    public function assignSubject($id) {
        $teacher = Teacher::findOrFail($id);

        $subjects = Subject::all();

        return view('backend.teachers.assignsubject', compact('teacher','subjects'));
    }

    public function storeAssignedSubject(Request $request, $id) {
        try {
            $validatedData = $request->validate([
                'subject' => 'required'
            ]);

            // dd($validatedData['subject']);
    
            $teacher = Teacher::findOrFail($id);

            $teacher->subjects()->sync($validatedData['subject']);
    
            // $teacher->update([
            //     'subject_id' => $validatedData['subject'],
            // ]);
    
            return redirect()->back()->with('success', 'Subject(s) assigned successfully!');
        } catch (\Exception $e) {
            //throw $th;
            Log::error("Error occured",['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return redirect()->back()->with('error', 'Error assigning subject!');

        }
       
    }

    public function profile2() {
        $teacher = Teacher::with(['user', 'subjects'])->get();

        return $teacher;

        return view('backend.teachers.profile', compact('teacher'));
    }

    public function deleteTeacher($id) {
        $teacher = Teacher::findOrFail($id);

        $teacher->delete();

        return redirect()->back()->with('success', 'Teacher deleted successfully.');
    }

    public function teachersSessionsIndex() {
        $teachers = Teacher::with('user')->get();

        // $diplomas = Diploma::all();
        return view('backend.teachers.sessionsindex', compact('teachers'));
    }

    public function createTeacherForm() {
        $diplomas = Diploma::all();
        $courses = Subject::all();

        return view('backend.teachers.create', compact('diplomas','courses'));
    }

    public function storeTeacher(Request $request) {
    try {
        $validatedData = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255',
            'password'  => 'required|string|min:8',
            'current_address' => 'required|string|max:255',
            'phone'     => 'required|string|max:255',
            'gender'    => 'required|string',
            'aca_prof'  => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData) {

            // Create user
            $user = User::create([
                'name'      => $validatedData['name'],
                'email'     => $validatedData['email'],
                'password'  => Hash::make($validatedData['password'])
            ]);

            // Create teacher profile
            $teacher = $user->teacher()->create([
                'gender'            => $validatedData['gender'],
                'phone'             => $validatedData['phone'],
                'current_address'   => $validatedData['current_address'],
                'employment_type'   => $validatedData['aca_prof'],
            ]);

            // Assign role
            $user->assignRole('Teacher');
        });

        return redirect()->back()->with('success', 'Teacher created successfully!');

    } catch (\Throwable $th) {

        Log::error("Error occurred", [
            'message' => $th->getMessage(),
            'trace' => $th->getTraceAsString()
        ]);

        return redirect()->back()->with('error', 'Error creating teacher');
    }
}


  

    public function assignSubjectsForm() {
        $teachers = Teacher::with('user')->get();

        $diplomas = Diploma::all('id', 'name', 'code');

        $assignedSubjects = TeacherSubject::with(['teacher.user', 'subject'])
                ->orderBy('created_at', 'desc')
                ->get();
        // return $assignedSubjects;
        return view('backend.teachers.assignsubjectsform', compact('teachers','diplomas', 'assignedSubjects'));
    }

    // public function assignSubjectsToTeacher(Request $request) {
    //     try {
    //         $rules = [
    //             'teacher_type' => 'required|string',
    //             'teacher_id' => 'required|exists:teachers,id',
    //             'subject_id' => 'required|exists:diploma,id',
    //         ];

    //         if ($request->teacher_type === 'Academic') {
    //             $rules['num_of_sessions'] = 'required|integer|min:0';
    //         } elseif ($request->teacher_type === 'Professional') {
    //             $rules['num_of_sessions'] = 'required|array';
    //             $rules['num_of_sessions.*'] = 'integer|min:0';
    //         }

    //         $validatedData = $request->validate($rules);

    //         $teacher = Teacher::findOrFail($validatedData['teacher_id']);
    //         $teacherType = $validatedData['teacher_type'];   // Academic or Professional
    //         $teacherId   = $validatedData['teacher_id'];
    //         $subjects    = $validatedData['subject_id'];

    //         if ($teacherType === 'Academic') {
    //             $sessions = $validatedData['num_of_sessions'];
    //             $totalSessions = $sessions;
    //         } else { // Professional
    //             $sessionsArray = $validatedData['num_of_sessions'];
    //             $sessions = json_encode($sessionsArray);
    //             $totalSessions = array_sum($sessionsArray);
    //         }

    //         DB::table('teacher_subject')->insert([
    //             'teacher_id' => $teacherId,
    //             'subject_id' => $subjects,
    //             'num_of_sessions' => $sessions,
    //             'remaining_sessions' => $totalSessions,
    //             'aca_prof' => $teacherType,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         return redirect()->back()->with('success', 'Subjects assigned to teacher successfully!');
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         Log::error("Error occured",['message' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);

    //         return redirect()->back()->with('error', 'Error assigning subjects to teacher');
    //     }
    // }

public function assignSubjectsToTeacher(Request $request) {
    try {

        // FIX: sanitize array BEFORE validation
        if ($request->has('num_of_sessions') && is_array($request->num_of_sessions)) {
            $sessions = $request->num_of_sessions;
            foreach ($sessions as $k => $v) {
                if ($v === null || $v === "" || $v === "none") {
                    $sessions[$k] = 0;
                }
            }
            $request->merge(['num_of_sessions' => $sessions]);
        }

        $rules = [
            'teacher_type' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:diploma,id',
        ];

        if ($request->teacher_type === 'Academic') {
            $rules['num_of_sessions'] = 'nullable|integer|min:0';
        } elseif ($request->teacher_type === 'Professional') {
            $rules['num_of_sessions'] = 'required|array';
            $rules['num_of_sessions.*'] = 'integer|min:0';
        }

        $validatedData = $request->validate($rules);

        $teacher = Teacher::findOrFail($validatedData['teacher_id']);
        $teacherType = $validatedData['teacher_type'];
        $teacherId   = $validatedData['teacher_id'];
        $subjects    = $validatedData['subject_id'];

        if ($teacherType === 'Academic') {
            $sessions = $validatedData['num_of_sessions'] ?? 0;
            $totalSessions = $sessions;
        } else {
            $sessionsArray = $validatedData['num_of_sessions'];
            $sessions = json_encode($sessionsArray);
            $totalSessions = array_sum($sessionsArray);
        }

        DB::table('teacher_subject')->insert([
            'teacher_id' => $teacherId,
            'subject_id' => $subjects,
            'num_of_sessions' => $sessions,
            'remaining_sessions' => $totalSessions,
            'aca_prof' => $teacherType,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Subjects assigned to teacher successfully!');
    } catch (\Throwable $th) {
        Log::error("Error occured",['message' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);
        return redirect()->back()->with('error', 'Error assigning subjects to teacher');
    }
}




    public function generateSalarySlip(Request $request) {
        $month = $request->input('month');
        $year = $request->input('year');

        $teachers = Teacher::with('user')->get();

        foreach ($teachers as $teacher) {
            $weekday = ProfSessionSalary::where('teaceher_id', $teacher->id)
                        ->where('session_type', 'weekday')
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->count();


            $weekend = ProfSessionSalary::where('teacher_id', $teacher->id)
                ->where('session_type', 'weekend')
                ->whereMonth('session_date', $month)
                ->whereYear('session_date', $year)
                ->count();

            $online = ProfSessionSalary::where('teacher_id', $teacher->id)
            ->where('session_type', 'olime')
            ->whereMonth('session_date', $month)
            ->whereYear('session_date', $year)
            ->count();           
    }   

    }

    public function teacherSessionsForm() {
        $teachers = Teacher::with('user')->get();

        $diplomas = Diploma::all('id', 'name', 'code');

        return view('backend.teachers.teachersessionsform', compact('teachers','diplomas'));
    }

    public function loadTeacherAttendance($id) {
        $teacher = Teacher::with('user')->findOrFail($id);

        $records = Attendance::where('teacher_id', $teacher->id)->orderBy('created_at', 'desc')->get();

        return view('backend.attendance.partials.teacher_form', compact('teacher', 'records'));
    }


    public function indexTeacher() {
        $teachers = Teacher::with('subjects.subject')->get();

        return view('backend.teachers.teachersessionsform', compact('teachers'));
    }

    public function getTeacherSubjects($teacherId)
    {
        $subjects = TeacherSubject::where('teacher_id', $teacherId)
            ->with('subject')
            ->get();

        return response()->json($subjects);
    }
    
    public function getAttendanceRecord($teacherId, $subjectId)
    {
        $attendance = Attendance::where('teacher_id', $teacherId)
            ->where('subject_id', $subjectId)
            ->orderBy('attendence_date', 'desc')
            ->get();

        $teacherSubject = TeacherSubject::where('teacher_id', $teacherId)
            ->where('subject_id', $subjectId)
            ->first();

        return response()->json([
            'attendance' => $attendance,
            'remaining_sessions' => $teacherSubject ? $teacherSubject->remaining_sessions : 0
        ]);
    }

    public function storeTeacherAttendance(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:diploma,id',
            'attendance_date' => 'required|date',
            'attendance_status' => 'required|in:present,absent',
            'type' => 'required|in:Weekend,Weekday,Online',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Check if attendance already exists for this date, teacher, and subject
                $existingAttendance = Attendance::where('teacher_id', $request->teacher_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('attendence_date', $request->attendance_date)
                    ->first();

                if ($existingAttendance) {
                    throw new \Exception('Attendance already taken for this date and subject.');
                }

                // Get the teacher subject record
                $teacherSubject = TeacherSubject::where('teacher_id', $request->teacher_id)
                    ->where('subject_id', $request->subject_id)
                    ->firstOrFail();

                // Check if sessions are available
                if ($teacherSubject->remaining_sessions <= 0) {
                    throw new \Exception('No sessions remaining for this subject.');
                }

                // Create attendance record
                Attendance::create([
                    'teacher_id' => $request->teacher_id,
                    'subject_id' => $request->subject_id,
                    'attendence_date' => $request->attendance_date,
                    'attendence_status' => $request->attendance_status,
                    'type' => $request->type,
                ]);

                // Decrement sessions only if attendance is present
                if ($request->attendance_status === 'present') {
                    $teacherSubject->decrementSessions();
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Attendance recorded successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function salaryReport(Request $request)
    {
        $currentMonth = now()->month; 
        $currentYear = now()->year;

        $report = $this->salaryService->generateSalaryReport($currentMonth, $currentYear);

        // return $report;

        return view('backend.teachers.teachersalary', compact('report'));
    }

    public function processPayment(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
            'method' => 'nullable|string',
        ]);

        try {
            $payment = $this->salaryService->processPayment(
                $request->teacher_id,
                $request->month,
                $request->year,
                $request->method
            );

            return redirect()
                ->back()
                ->with('success', 'Payment processed successfully');

        } catch (\Exception $e) {
            // Log the failure with context
            Log::error('Teacher payment failed', [
                'teacher_id' => $request->teacher_id,
                'month'      => $request->month,
                'year'       => $request->year,
                'method'     => $request->method,
                'error'      => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }


    public function paymentHistory()
    {
        $payments = TeacherPayment::with('teacher')->latest()->paginate(20);
        return view('backend.attendance.partials.teacher_form', compact('payments'));
    }

    public function salaryReportsForm()
    {
        $teachers = Teacher::all();
        return view('backend.teachers.salaryreportsform',compact('teachers'));
    }

    public function getTeacherSalaryReport(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'month' => 'required|integer|between:1,12',
                'year' => 'required|integer',
            ]);

            $teacher = Teacher::with(['subjectAssignments','attendances' => function($query) use ($validatedData) {
                $query->whereYear('attendence_date', $validatedData['year'])
                      ->whereMonth('attendence_date', $validatedData['month'])
                      ->where('attendence_status', 'present');
            },'payments','attendances.subject'])->findOrFail($validatedData['teacher_id']);

            $subjectsWithRemainingSessions = $teacher->getSubjectsWithRemainingSessions();

            // Calculate salary using the service
            $salaryData = $this->salaryService->calculateTeacherSalary($teacher, $validatedData['month'], $validatedData['year']);

            return view('backend.teachers.teachersalaryreport', compact('teacher','subjectsWithRemainingSessions', 'salaryData', 'validatedData'));
        } catch (\Exception $th) {
            Log::error("Error occurred", [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Error generating salary report: ' . $th->getMessage());
        }
    }

    public function manageTeacher()
    {
        $teachers = Teacher::with(['user','subjects'])->latest()->paginate(10);

        $diplomas = Diploma::all();

        return view('backend.teachers.manageteachers', compact('teachers','diplomas'));
    }

    public function getTeacherSessions($teacherId, $subjectId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        $numSessions = $teacher->subjects()
            ->where('subject_id', $subjectId)
            ->value('num_of_sessions');

        $remainingSessions = $teacher->subjects()->where('subject_id', $subjectId)->value('remaining_sessions');

        return response()->json([
            'total_sessions' => $numSessions,
            'remaining_sessions' => $remainingSessions
        ]);
    }

    public function updateTeacherSessions(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:diploma,id',
            'sessions_per_month' => 'required|integer|min:0',
            'remaining_sessions' => 'required|integer|min:0',
        ]);

        try {
            $teacherSubject = TeacherSubject::where('teacher_id', $request->teacher_id)
                ->where('subject_id', $request->subject_id)
                ->firstOrFail();

            $teacherSubject->update([
                'num_of_sessions' => $request->sessions_per_month,
                'remaining_sessions' => $request->remaining_sessions,
            ]);

            return redirect()->back()->with('success', 'Sessions updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating teacher sessions', [
                'teacher_id' => $request->teacher_id,
                'subject_id' => $request->subject_id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Error updating sessions.');
        }
    }




}
