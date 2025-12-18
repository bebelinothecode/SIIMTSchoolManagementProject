<?php

namespace App\Http\Controllers;

use App\Fees;
use App\User;
use App\Grade;
use App\Level;
use Exception;
use App\Diploma;
use App\Enquiry;
use App\Parents;
use App\LecturerEvaluationSubmission;
use App\LecturerEvaluationDetail;
use App\Session;
use App\FeesPaid;
use App\Student;
use App\PaymentPlan;
use App\Installments;
use App\Subject;
use App\FeesType;
use Carbon\Carbon;
use App\AcademicYear;
use App\Defer;
// use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\MatureStudent;
use App\RegisterCourse;
use Illuminate\Validation\ValidationException;
use Dotenv\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Schema\ValidationException as SchemaValidationException;
use PragmaRX\Countries\Package\Countries;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort');

        $query = Student::with('user','paymentPlans.installments', 'course', 'diploma')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->whereNull('users.deleted_at')
            ->where(function ($q) {
                $q->whereNotNull('course_id')
                    ->orWhereNotNull('course_id_prof');
            });

        if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('users.name', 'like', '%' . $request->search . '%')
                ->orWhere('users.email', 'like', '%' . $request->search . '%')
                ->orWhere('students.index_number', 'like', '%' . $request->search . '%')
                ->orWhereHas('course', function ($subQ) use ($request) {
                    $subQ->where('course_name', 'like', '%'. $request->search. '%');
                })
                ->orWhereHas('diploma', function ($qq) use ($request) {
                    $qq->where('name', 'like', '%'.$request->search. '%');
                });
          });
       }

        if ($sort === 'Academic' || $sort === 'Professional') {
        $query->where('student_category', $sort);
        }

        if($sort === 'Kasoa' || $sort === 'Kanda' || $sort === 'Spintex') {
            $query->where('branch', $sort);
        }

        $students = $query->orderBy('users.name', 'asc')
        ->select('students.*') // Prevents column conflicts between students and users
        ->paginate(10);

        // return $students;

        return view('backend.students.index', compact('students'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Grade::latest()->get();
        $parents = Parents::with('user')->latest()->get();
        $diplomas = Diploma::all();
        // $sessions = Session::all();
        $years = AcademicYear::all();
        // $levels = Level::all();
        
        return view('backend.students.create', compact('courses','parents', 'diplomas','years'));
    }

    

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {
        try {
            // dd($request->all());
            $rules = [
                'branch' => 'required|string|in:Kasoa,Spintex,Kanda',
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'phone' => 'required|string|max:20',
                'gender' => 'required|in:male,female,other',
                'attendance_time' => 'required|in:weekday,weekend',
                'dateofbirth' => 'required|date',
                'current_address' => 'required|string',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'student_parent' => 'required|string|max:255',
                'parent_phonenumber' => 'required|string|max:15',
                'student_category' => 'required|in:Professional,Academic',
                'scholarship' => 'required|in:Yes,No',
                'student_type' => 'required|in:Local,Foreign',
                'admission_cycle' => 'nullable|in:February,August',
                'scholarship_amount' => 'nullable|numeric|required_if:scholarship,Yes',
                'pay_fees_now' => 'nullable',
                'amount_paid' => 'nullable|string',
                'new_student_balance' => 'nullable|string',
            ];
    
            if ($request->student_category === 'Professional') {
                $rules['course_id_prof'] = 'required|exists:diploma,id';
                $rules['currency_prof'] = 'required|string';
                $rules['fees_prof'] = 'required|numeric';
                $rules['duration_prof'] = 'required|string';
            } elseif ($request->student_category === 'Academic') {
                $rules['course_id'] = 'required|exists:grades,id';
                $rules['currency'] = 'required|string';
                $rules['fees'] = 'required|numeric';
                $rules['level'] = 'required|in:100,200,300,400';
                $rules['session'] = 'required|in:1,2';
                $rules['academicyear'] = 'required';
            }
    
            $validatedData = $request->validate($rules);
    
            DB::beginTransaction();
    
            // Create User
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password'])
            ]);
    
            // Profile picture
            if ($request->hasFile('profile_picture')) {
                $profile = Str::slug($user->name) . '-' . $user->id . '.' . $request->profile_picture->getClientOriginalExtension();
                $request->profile_picture->move(public_path('images/profile'), $profile);
            } else {
                $profile = 'avatar.png';
            }
            $user->update(['profile_picture' => $profile]);
    
            // === Professional Student ===
            if ($validatedData['student_category'] === 'Professional') {
                $courseID = $validatedData['course_id_prof'];
                $query = Diploma::findOrFail($courseID);
    
                $student = $user->student()->create([
                    'branch'              => $validatedData['branch'],
                    'phone'               => $validatedData['phone'],
                    'gender'              => $validatedData['gender'],
                    'attendance_time'     => $validatedData['attendance_time'],
                    'dateofbirth'         => $validatedData['dateofbirth'],
                    'current_address'     => $validatedData['current_address'],
                    'student_parent'      => $validatedData['student_parent'],
                    'parent_phonenumber'  => $validatedData['parent_phonenumber'],
                    'student_category'    => $validatedData['student_category'],
                    'course_id_prof'      => $validatedData['course_id_prof'],
                    'currency_prof'       => $validatedData['currency_prof'],
                    'fees_prof'           => $validatedData['fees_prof'],
                    'balance'             => $validatedData['fees_prof'],
                    'duration_prof'       => $validatedData['duration_prof'],
                    'Scholarship'         => $validatedData['scholarship'],
                    'student_type'        => $validatedData['student_type'],
                    'admission_cycle'     => $validatedData['admission_cycle'],
                    'Scholarship_amount'  => $validatedData['scholarship_amount'],
                    'status'              => ($validatedData['pay_fees_now'] === 'yes') ? 'Active' : 'Pending',
                    'pay_fees_now'     => $validatedData['pay_fees_now'] ?? null,
                    'amount_paid'     => $validatedData['amount_paid'] ?? null,
                    'new_student_balance' => $validatedData['new_student_balance'] ?? null,
                ]);
            }
    
            // === Academic Student ===
            elseif ($validatedData['student_category'] === 'Academic') {
                $courseID = $validatedData['course_id'];
                $query = Grade::findOrFail($courseID);
    
                $student = $user->student()->create([
                    'branch'              => $validatedData['branch'],
                    'phone'               => $validatedData['phone'],
                    'gender'              => $validatedData['gender'],
                    'attendance_time'     => $validatedData['attendance_time'],
                    'dateofbirth'         => $validatedData['dateofbirth'],
                    'current_address'     => $validatedData['current_address'],
                    'student_parent'      => $validatedData['student_parent'],
                    'parent_phonenumber'  => $validatedData['parent_phonenumber'],
                    'student_category'    => $validatedData['student_category'],
                    'course_id'           => $validatedData['course_id'],
                    'currency'            => $validatedData['currency'],
                    'fees'                => $validatedData['fees'],
                    'balance'             => $validatedData['fees'],
                    'level'               => $validatedData['level'],
                    'session'             => $validatedData['session'],
                    'student_type'        => $validatedData['student_type'],
                    'admission_cycle'     => $validatedData['admission_cycle'],
                    'academicyear'        => $validatedData['academicyear'],
                    'Scholarship'         => $validatedData['scholarship'],
                    'Scholarship_amount'  => $validatedData['scholarship_amount'],
                    'status'              => ($validatedData['pay_fees_now'] === 'yes') ? 'Active' : 'Pending',
                    'pay_fees_now'        => $validatedData['pay_fees_now'] ?? null,
                    'amount_paid'         => $validatedData['amount_paid'] ?? null,
                    'new_student_balance' => $validatedData['new_student_balance'] ?? null,
                ]);
            }

            $user->assignRole('Student');
            DB::commit();
    
      
            if($validatedData['pay_fees_now'] === 'yes') {
                
                $receipt_number = "RCPT-".date('Y-m-d')."-".strtoupper(Str::random(8));
                $idempotencyKey = (string) Str::uuid();

                $feespaid = FeesPaid::create([
                    'student_index_number' => $student->index_number,
                    'student_name' => $student->user->name,
                    'student_id' => $student->id,
                    'method_of_payment' => "Cash",
                    'amount' => $student->amount_paid,
                    'balance' => $student->new_student_balance,
                    'currency' => "Ghana Cedi",
                    'Momo_number' => $validatedData['Momo_number'] ?? null,
                    'cheque_number' => $validatedData['cheque_number'] ?? null,
                    'remarks' => $validatedData['remarks'] ?? null,
                    'receipt_number' => $receipt_number,
                    'fees_type' => $validatedData['fees_type'] ?? null,
                    'other_fees' => $validatedData['other_fees'] ?? null,
                    'late_fees_charges' => $validatedData['late_fees_charges'] ?? null,
                    'idempotency_key' => $idempotencyKey
                ]);

                // Redirect back with success message and receipt URL to open in a new tab
                $receiptUrl = route('backend.fees.receipt', $feespaid->id);

                return redirect()->back()->with([
                    'success' => 'Student created successfully and fees collected.',
                    'open_receipt' => $receiptUrl
                ]);
            }
            return redirect()->back()->with('success', 'Student created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating student: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An error occurred while creating the student. Please try again.']);
        }
    }

    protected function handleImmediatePayment($student, $validatedData)
    {
        $receipt_number = "RCPT-" . date('Y-m-d') . "-" . strtoupper(Str::random(8));
        $idempotencyKey = (string) Str::uuid();

        $feespaid = FeesPaid::create([
            'student_index_number' => $student->index_number,
            'student_name'         => $student->user->name,
            'student_id'           => $student->id,
            'method_of_payment'    => "Cash",
            'amount'               => $student->amount_paid,
            'balance'              => $student->new_student_balance,
            'currency'             => "Ghana Cedi",
            'receipt_number'       => $receipt_number,
            'idempotency_key'      => $idempotencyKey,
        ]);

        return redirect()->route('fees.receipt', $feespaid->id)->with('open_receipt', true);
    }

    


    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::with(['course', 'diploma'])
            ->where('id', $id)
            ->where(function ($query) {
                $query->whereNotNull('course_id')
                    ->orWhereNotNull('course_id_prof');
            })
            ->findOrFail($id);

        // return $student;

        $transactions = FeesPaid::where('student_index_number', $student->index_number)->latest()->get();

        // return $transactions;

        return view('backend.students.show', compact('student', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);

        if ($student->student_category === 'Academic') {
            $courses = Grade::all();
        } elseif ($student->student_category === 'Professional') {
            $courses = Diploma::all();
        } else {
            return redirect()->back()->with('error', 'Error loading Courses');
        }

        return view('backend.students.edit', compact('courses','student'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $user = User::findOrFail($student->user_id);
        $user->student()->delete();
        $user->removeRole('Student');

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

    public function all() {
        $courses = Student::with('user')->get();

        return $courses;
    }

    /**
     * Show form to enter admission letter details
     */
    public function printAdmissionLetterForm($id) {
        $student = Student::with('user', 'course', 'diploma')
            ->where(function ($q) {
                $q->whereNotNull('course_id')
                ->orWhereNotNull('course_id_prof');
            })->findOrFail($id);

        $academicyear = AcademicYear::latest()->first();

        return view('backend.students.admissionLetterForm', compact('student', 'academicyear'));
    }

    /**
     * Show preview of admission letter with entered details
     */
    public function previewAdmissionLetter(Request $request, $id) {
        $student = Student::with('user', 'course', 'diploma')
            ->where(function ($q) {
                $q->whereNotNull('course_id')
                ->orWhereNotNull('course_id_prof');
            })->findOrFail($id);

        $academicyear = AcademicYear::latest()->first();

        // Validate inputs
        $validated = $request->validate([
            'academic_year' => 'required|string|max:255',
            'resumption_date' => 'required|date',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'orientation_date' => 'required|date',
            'lectures_begin_date' => 'required|date',
        ]);

        // Format dates for display
        $letter_details = [
            'academic_year' => $validated['academic_year'],
            'resumption_date' => $validated['resumption_date'],
            'resumption_date_formatted' => $this->formatDateForLetter($validated['resumption_date']),
            'registration_start_date' => $validated['registration_start_date'],
            'registration_start_date_formatted' => $this->formatDateForLetter($validated['registration_start_date']),
            'registration_end_date' => $validated['registration_end_date'],
            'registration_end_date_formatted' => $this->formatDateForLetter($validated['registration_end_date']),
            'orientation_date' => $validated['orientation_date'],
            'orientation_date_formatted' => $this->formatDateForLetter($validated['orientation_date']),
            'lectures_begin_date' => $validated['lectures_begin_date'],
            'lectures_begin_date_formatted' => $this->formatDateForLetter($validated['lectures_begin_date']),
        ];

        return view('backend.students.admissionLetterPreview', compact('student', 'academicyear', 'letter_details'));
    }

    /**
     * Print admission letter with entered details
     */
    public function printAdmissionLetter(Request $request, $id) {
        $student = Student::with('user', 'course', 'diploma')
            ->where(function ($q) {
                $q->whereNotNull('course_id')
                ->orWhereNotNull('course_id_prof');
            })->findOrFail($id);

        $academicyear = AcademicYear::latest()->first();

        // Get letter details from request
        $letter_details = [];
        if ($request->has('letter_details')) {
            try {
                $letter_details = json_decode(base64_decode($request->input('letter_details')), true);
            } catch (\Exception $e) {
                // If decode fails, show form again
                return redirect()->route('student.print.form', $id);
            }
        } else {
            // No details provided, show form
            return redirect()->route('student.print.form', $id);
        }

        return view('backend.students.printletter', compact('student', 'academicyear', 'letter_details'));
    }

    /**
     * Helper method to format date for letter (e.g., "Monday, 17 February 2025")
     */
    private function formatDateForLetter($date) {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('l, d F Y');
    }

    public function studentSchoolFees(Request $request) {
        $sort = $request->input('sort');
        $query = Grade::query();

        $queryDiploma = Diploma::query();

        $acaFees = null;
        $profFees = null;

        if($sort === 'Academic') {
           $acaFees = $query->get();
        } elseif($sort === 'Professional') {
            $profFees = $queryDiploma->get();
        }

        // $academicFees = Grade::paginate(10);

        // $professionalFees = Diploma::paginate(10);

        return view('backend.students.schoolfees', compact('sort','acaFees','profFees'));
    }

    public function test2() {
        $students = Student::with(['class','parent'])->get(); // Eager load the 'class' relationship
        return $students;
    }

    public function studentEnquiry(Request $request)
    {
        // Get the sorting parameter from the request
        $sort = $request->query('sort');

        // Query the enquiries
        $enquiries = Enquiry::with(['diploma','course'])->when($sort, function ($query, $sort) {
            // Filter by type_of_course if a sort value is provided
            return $query->where('type_of_course', $sort);
        })
        ->latest() // Sort by the latest entries
        ->paginate(5); // Paginate the results

        // return $enquiries;

        $searchTerm = $request->input('search');

        $results = Enquiry::where(function ($query) use ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('telephone_number', 'LIKE', "%{$searchTerm}%")
                // ->orWhere('interested_course', 'LIKE', "%{$searchTerm}%")
                ->orWhere('bought_forms', 'LIKE', "%{$searchTerm}%")
                ->orWhere('amount', 'LIKE', "%{$searchTerm}%");
        })->get();

        // Return the view with the enquiries data
        return view('backend.students.enquiry', compact('enquiries'));
    }

    
    public function index22(Request $request)
    {
        // Fetch enquiries with sorting
        $sort = $request->input('sort'); // Get sorting filter

        $enquiries = Enquiry::query();

        // Apply sorting filter (Academic or Professional)
        if ($sort === 'Academic' || $sort === 'Professional') {
            $enquiries->where('type_of_course', $sort);
        }

        // Paginate results
        $enquiries = $enquiries->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.students.enquiry', compact('enquiries'));
    }




    // public function index22(Request $request)
    // {
    //     // Fetch enquiries with sorting
    //     $sort = $request->input('sort'); // Get sorting filter

    //     $enquiries = Enquiry::query();

    //     // Apply sorting filter (Academic or Professional)
    //     if ($sort === 'Academic' || $sort === 'Professional') {
    //         $enquiries->where('type_of_course', $sort);
    //     }

    //     // Paginate results
    //     $enquiries = $enquiries->orderBy('created_at', 'desc')->paginate(10);

    //     return view('backend.students.enquiry', compact('enquiries'));
    // }

    public function saveStudentEnquiry() {
        $courses = Grade::all();

        $diplomas = Diploma::all();

        // $dropdownItems = $courses->map(function ($course) {
        //     return ['id' => $course->id, 'name' => $course->course_name];
        // })->merge($diplomas->map(function ($diploma) {
        //     return ['id' => $diploma->id, 'name' => $diploma->name];
        // }));

        return view('backend.students.enquiryform', compact('courses','diplomas'));
    }

    public function updateEnquiry(Request $request, $id) {
        try {
            // dd($request->all());
            $validatedData = $request->validate([
                'name' => 'required|string',
                'telephone_number' => 'required|string',
                'diploma_id' => 'nullable|integer',
                'expected_start_date' => 'required',
                'type_of_course' => 'required',
                'bought_forms' => 'nullable|in:Yes,No',
                'currency' => 'nullable|string',
                'amount_paid' => 'nullable|numeric',
                'User' => 'nullable|string',
                'course_id' => 'nullable|integer',
                'branch' => 'nullable|in:Kasoa,Spintex,Kanda',
                'source_of_enquiry' => 'nullable|string|max:255',
                'preferred_time' => 'nullable|string|in:Weekday,Weekend',
                'method_of_payment' => 'nullable|string|max:255',
            ]);
    
            $enquiry = Enquiry::findOrFail($id);
    
            $enquiry->update([
                'name' => $validatedData['name'],
                'telephone_number' => $validatedData['telephone_number'],
                'course_id' => $validatedData['course_id'],
                'diploma_id' => $validatedData['diploma_id'],
                'expected_start_date' => $validatedData['expected_start_date'],
                'type_of_course' => $validatedData['type_of_course'],
                'bought_forms' => $validatedData['bought_forms'],
                'currency' => $validatedData['currency'],
                'amount' => $validatedData['amount_paid'],
                'branch' => $validatedData['branch'],
                // 'receipt_number' => $receiptNumber,
                // 'User' => Auth::user()->name,
                'source_of_enquiry' => $validatedData['source_of_enquiry'] ?? $enquiry->source_of_enquiry,
                'preferred_time' => $validatedData['preferred_time'] ?? $enquiry->preferred_time,
                'method_of_payment' => $validatedData['method_of_payment'] ?? $enquiry->method_of_payment,
            ]);
    
            return redirect()->back()->with('success', 'Enquiry updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            //throw $th;
            Log::error('Validation errors: ', $e->errors());
            return redirect()->back()->with('error', 'Error updating Enquiry'); 
        }
    }

    public function storeEnquiry(Request $request) {
        try {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string',
            'telephone_number' => 'required|string',
            'diploma_id' => 'nullable|integer',
            'expected_start_date' => 'required',
            'type_of_course' => 'required',
            'bought_forms' => 'nullable|in:Yes,No',
            'currency' => 'nullable|string',
            'amount_paid' => 'nullable|numeric',
            'User' => 'nullable|string',
            'course_id' => 'nullable|integer',
            'branch' => 'nullable|in:Kasoa,Spintex,Kanda',
            'source_of_enquiry' => 'nullable|string|max:255',
            'preferred_time' => 'nullable|string|in:Weekday,Weekend',
            'method_of_payment' => 'nullable|string|max:255',
        ]);

        $receiptNumber = "RCPT-".date('Y-m-d')."-".strtoupper(Str::random(8));

        $existingEnquiry = Enquiry::where('receipt_number', $receiptNumber)->first();

        if ($existingEnquiry) {
            return view('backend.fees.enquiryreceipt', compact('existingEnquiry', 'receiptNumber'));
        }

        $enquiry = Enquiry::create([
            'name' => $validatedData['name'],
            'telephone_number' => $validatedData['telephone_number'],
            'course_id' => $validatedData['course_id'],
            'diploma_id' => $validatedData['diploma_id'],
            'expected_start_date' => $validatedData['expected_start_date'],
            'type_of_course' => $validatedData['type_of_course'],
            'bought_forms' => $validatedData['bought_forms'],
            'currency' => $validatedData['currency'],
            'amount' => $validatedData['amount_paid'],
            'branch' => $validatedData['branch'],
            'receipt_number' => $receiptNumber,
            'User' => Auth::user()->name,
            'source_of_enquiry' => $validatedData['source_of_enquiry'] ?? 'Not Specified',
            'preferred_time' => $validatedData['preferred_time'] ?? 'Not Specified',
            'method_of_payment' => $validatedData['method_of_payment'] ?? 'Not Specified',
        ]);

        if($validatedData['bought_forms'] === 'Yes') {
            return view('backend.fees.enquiryreceipt',compact('enquiry','receiptNumber'));
        }

        return redirect()->back()->with('success', 'Enquiry created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            //throw $th;
            Log::error('Validation errors: ', $e->errors());

            return redirect()->back()->with('error', 'Error saving Enquiry');
        } 
    }

    public function migration() {
        $levels = Level::all('name');
        $semesters = Session::all(['name']);

        return view("backend.students.migration", compact('levels', 'semesters'));
    }
   
    public function updateStudent(Request $request, $id) {
        try {
           

            // dd($request->all());
            $validatedData = $request->validate([
                            'name' => 'required|string|max:255',
                            'email' => 'required|email|max:255',
                            'phone' => 'required|string|max:20',
                            'gender' => 'required|in:male,female,other',
                            'dateofbirth' => 'required|date',
                            'current_address' => 'required|string',
                            'fees' => 'required|numeric|min:0',
                            'level' => 'nullable|in:100,200,300,400',
                            'session' => 'nullable|in:1,2',
                            'currency' => 'required|string|max:15',
                            'balance' => 'required|numeric',
                            // 'course_id' => 'required|integer',
                            'parent_phonenumber' => 'nullable|string|max:15',
                            'change_status' => 'nullable|in:active,defer,completed',
                        ]);
            // $validatedData = $request->validate([
            //     'change_status' => 'required|in:active,defer,completed',
            // ]);
            $student = Student::findOrFail($id);

            // return $student;

            $profilePicture = $student->user->profile_picture;
            if ($request->hasFile('profile_picture')) {
                $extension = $request->file('profile_picture')->getClientOriginalExtension();
                $profilePicture = Str::slug($student->user->name) . '-' . $student->user->id . '.' . $extension;
                $request->file('profile_picture')->move(public_path('images/profile'), $profilePicture);
            }

            // $student->student()->update([
            //     'status' => $validatedData['change_status'],
            // ]);

            // $student->user()->update($userFieldsToUpdate);
            $student->user()->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'profile_picture' => $profilePicture
            ]);

            $academicStudentFields = [
                'phone' => $validatedData['phone'],
                'gender' => $validatedData['gender'],
                'dateofbirth' => $validatedData['dateofbirth'],
                'current_address' => $validatedData['current_address'],
                'balance' => $validatedData['balance'],
                'level' => $validatedData['level'] ?? $student->level, // Keep existing level if not provided
                'session' => $validatedData['session'] ?? $student->session, // Keep existing session if not provided
                'course_id' => $student->course_id,
                'currency' => $validatedData['currency'],
                'fees' => $validatedData['fees'],
            ];

            $profStudentFields = [
                'phone' => $validatedData['phone'],
                'gender' => $validatedData['gender'],
                'dateofbirth' => $validatedData['dateofbirth'],
                'current_address' => $validatedData['current_address'],
                'balance' => $validatedData['balance'],
                'fees_prof' => $validatedData['fees'],
                'course_id_prof' => $student->course_id_prof,
            ];

            if($student->student_category === 'Academic') {
                $student->update($academicStudentFields);
            } elseif($student->student_category === 'Professional') {
                $student->update($profStudentFields);
            } else {
                return redirect()->back()->with('error', 'Invalid student category');
            }

            // Update common fields
            $student->update([
                'parent_phonenumber' => $validatedData['parent_phonenumber'] ?? $student->parent_phonenumber,
                'status' => $validatedData['change_status'] ?? $student->status,
            ]);

            return redirect()->back()->with('success', 'Student updated successfully');
      
        } catch (Exception $e) {
            Log::error(message: "Error occured updating student" .$e);

            return redirect()->back()->with('error', 'Error updating Student');
        }
    }
    
    public function payStudentFeesForm($id) {
        $student = Student::with('user')->findOrFail($id);
        $levelChanged = $student->level !== $student->last_level;
        $semesterChanged = $student->session !== $student->last_semester;
        $studentName = $student->user->name;
        $studentIndexNumber = $student->index_number;
        $student_balance = $student->balance;
        $studentId = $student->id;
        $feesTypes = FeesType::all();
        // return $student;
        // return [$levelChanged, $semesterChanged];
        return view('backend.students.payfeesform', compact('studentId','student','studentName','studentIndexNumber','student_balance','feesTypes','levelChanged','semesterChanged'));
    }

    public function promoteAll(Request $request) {
        try {
            $validatedData = $request->validate([
                'current_level' => 'required',
                'current_semester' => 'required',
                'target_level' => 'required',
                'target_semester'=>'required'
            ]);

            $fromLevel = $validatedData['current_level'];
            $fromSemester = $validatedData['current_semester'];
            $toLevel = $validatedData['target_level'];
            $toSemester = $validatedData['target_semester'];

            if (($fromSemester === $toSemester) && ($fromLevel === $toLevel)) {
                return redirect()->back()->with('error', 'Cant migrate to the same semester or level');
            }

            $students = Student::with('user')->where('level', $fromLevel)
                                ->where('session', $fromSemester)
                                ->get();

            if ($students->isEmpty()) {
                return redirect()->back()->with('error', 'No students found');
            }

            foreach($students as $student) {
                $oldBalance = $student->balance;
                $newSemesterFee = $student->fees ?? 0; 
                $student->balance = $oldBalance + $newSemesterFee;

                // Update the student's last level and semester
                $student->last_level = $student->level;
                $student->last_semester = $student->session;
                $student->level = $toLevel;
                $student->session = $toSemester;
                $student->save();
            }

            return redirect()->back()->with('success', 'Students migrated successfully');
        } catch (Exception $e) {
            Log::error('An error occurred', [
                'exception' => $e 
            ]);   
            return redirect()->back()->with('error', 'Error saving students details');
        }
    }

    public function courseOverviewForm($id) {
        $course = Grade::findOrFail($id);
        $subjects = Subject::all();
        $levels = Level::all();
        $semesters = Session::all();
        
        return view('backend.students.courseoutline', compact('subjects','course','levels','semesters'));
    }

    function searchString($mainString, $searchString) {
        return Str::contains($mainString, $searchString);
    }

    public function  courseOverviewReport(Request $request, $id) {
        //Assigning subjects to a course controller
        try {
            // dd($request->all());
            $validatedData = $request->validate([
                'subject' => 'required',
                'level_id' => 'required',
                'semester_id' => 'required'
            ]);

            $subjects_ids = $validatedData['subject'];
            $level_id = $validatedData['level_id'];
            $semester_id = $validatedData['semester_id'];

            $grade = Grade::findOrFail($id);

            foreach ($subjects_ids as $subjects_id) {
                $grade->assignSubjectsToCourse()->attach($subjects_id, [
                    'level' => $level_id,
                    'semester' => $semester_id
                ]);
            }

            // $grade->assignSubjectsToCourse()->sync([$subject_id,$level_id,$semester_id]);  
            
            return redirect()->back()->with('success', 'Subject(s) assigned successfully!');
        } catch (Exception $e) {
            //throw $th;
            Log::error("Error occured",['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return redirect()->back()->with('error', 'Error assigning subject!');
        }
    }                                                                                                  

    public function test22(Request $request)
    {
        // Validate the search input
        // $request->validate([
        //     'search' => 'nullable|string|max:255',
        // ]);

        // Start the query with eager loading
        $query = Student::with('user', 'course', 'diploma')
            ->where(function ($q) {
                $q->whereNotNull('course_id')
                ->orWhereNotNull('course_id_prof');
            });

        // Apply search filter if a search term is provided
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('user', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
                })
                ->orWhere('index_number', 'like', '%' . $searchTerm . '%');
            });
        }

    // Fetch paginated results
    $students = $query->latest()->paginate(10); // Adjust pagination size as needed

    // return $students;

    return view('backend.students.index', compact('students'));
    }

    public function showImportForm() {
        return view('backend.students.importform');
    }

    public function import(Request $request) {
        try {
            //code...
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:10240'
            ]);

            DB::beginTransaction();
    
            Excel::import(new StudentsImport, $request->file('file'));

            DB::commit();
    
            return redirect()->back()->with('success', 'Students imported successfully!');
        } catch (Exception $e) {
            //throw $th;
            DB::rollBack();
            Log::error("Error occured",['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return redirect()->back()->with('error', 'Error uploading file');
        }
    }

    public function getDocumentRequestForm() {
        return view('backend.students.documentrequest');
    }

    public function submitDocumentForm(Request $request) {
        try {
            //code...
            dd($request->all());
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getCourseOutlineForm() {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->back()->with('error', 'User not authenticated');
        }

        $user = User::findOrFail($userId);
        // Get student record
        $student = Student::with('user')->where('user_id', $userId)->first();


        // return $student;
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found');
        }

        // return $student;

        // Determine course ID (handling both regular and professor cases)
        $courseId = $student->course_id ?? $student->course_id_prof;

        if($student->course_id_prof) {
            return view('backend.students.getcourseoutline', compact('student'));
        }

        if (!$courseId) {
            return redirect()->back()->with('error', 'No course assigned to student');
        }   

   
      $subjects = Subject::where('course_id', $student->course_id)
        ->orderBy('level')
        ->orderBy('semester')
        ->get()
        ->groupBy(['level', 'semester']);

        return view('backend.students.getcourseoutline',compact('subjects', 'student'));
    }

    public function registerCoursesForm($id) {
        $student = Student::with(['user','course','diploma'])->findOrFail($id);

        $subjects = Subject::where('course_id', $student->course_id)
        ->semester()
        ->orderBy('level')
        ->orderBy('semester')
        ->get()
        ->groupBy(['level', 'semester']);

        $courses = null;

        if($student->student_category === 'Academic') {
            $courses = Grade::all();
        } elseif($student->student_category === 'Professional') {
            $courses = Diploma::all();
        }

        return view('backend.students.registercoursesform',compact('student','courses'));
    }

    // public function getCourseOutlineForm()
    // {
    //     try {
    //         // Get authenticated user
    //         $userId = Auth::id();
    //         if (!$userId) {
    //             throw new Exception('User not authenticated');
    //         }

    //         // Get student record
    //         $student = DB::table('students')
    //             ->where('user_id', $userId)
    //             ->first();

    //         if (!$student) {
    //             throw new Exception('Student record not found');
    //         }

    //         // Determine course ID (handling both regular and professor cases)
    //         $courseId = $student->course_id ?? $student->course_id_prof;
    //         if (!$courseId) {
    //             throw new Exception('No course assigned to student');
    //         }

    //         // Get course with subjects grouped by level and semester
    //         $course = Grade::with(['assignSubjectsToCourse' => function ($query) {
    //             $query->withPivot('level_id', 'semester_id')
    //                 ->orderBy('pivot_level_id')
    //                 ->orderBy('pivot_semester_id');
    //         }])->findOrFail($courseId);

    //         // Group subjects by level and semester
    //         $subjects = $course->assignSubjectsToCourse->groupBy(function ($subject) {
    //             return 'Level ' . $subject->pivot->level_id . ' - Semester ' . $subject->pivot->semester_id;
    //         });

    //         return $subjects;

           

    //     } catch (Exception $e) {
    //         Log::error('Error in getCourseOutlineForm: ' . $e->getMessage());
            
    //         return redirect()->back()->with('error', 'Failed to load course outline: ' . $e->getMessage());
    //     }
    // }

    public function getRegistrationForm() {
        $studentId = Auth::user()->id;

        $student = DB::table('students')
                ->where('user_id', $studentId)
                ->first();

        $course = Grade::findOrFail($student->course_id);

        $query = Subject::query();

        if(($student->level == '100' && $student->session == '1') || ($student->level == '200' && $student->session == '1')) {
            $query = Subject::where('level',$student->level)
            ->whereIn('semester',["1", "2"]);
        } elseif($student->level == '100' && $student->session == '2') {
            $query = Subject::where('level',$student->level)
            ->where('semester', "2");
        } else {
            $query = Subject::where('level',$student->level)->where('semester',$student->session);
        }
        
        $allSubjects = $query->get();

        return view('backend.students.registercourse',compact('course','allSubjects','student','studentId'));
    }

    public function registerCourses(Request $request, $id) {
        try {
            // dd($request->all());
            $validatedData = $request->validate([
                'level' => 'required',
                'semester' => 'required',
                'subjects_id' => 'required'
            ]);

            $studentId = Auth::user()->id;

            $student = DB::table('students')
            ->where('user_id', $studentId)
            ->first();

            $level = $validatedData['level'];
            $semester = $validatedData['semester'];
            $course_id = $student->course_id;
            $subjects = $validatedData['subjects_id'];

            foreach ($subjects as $subjectId) {
                RegisterCourse::create([
                    'student_id' => $id,
                    'level' => $level,
                    'semester' => $semester,
                    'subjects_id' => $subjectId,
                    'course_id' => $course_id 
                ]);
            }

            return redirect()->back()->with('success', 'You have registered the selected courses successfully');
        } catch (Exception $e) {
            //throw $th;
            Log::error("Error occured registering selected courses",['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return redirect()->back()->with('error','Error registering selected courses');
        }
    }

    public function getCurrentSemesterCourses() {
        $user_id = Auth::user()->id;

        $studentInfo = DB::table('students')
        ->where('user_id', $user_id )
        ->first();

        $currentCourses = RegisterCourse::with('subjects')
        ->where('student_id',$studentInfo->id)
        ->where('course_id',$studentInfo->course_id)
        ->where('semester',$studentInfo->session)
        ->where('level',$studentInfo->level)->get();

        return view('dashboard.student',compact('currentCourses'));
    }

    public function showRegisteredCourses() {
        $studentId = Auth::user()->id;

        $userData = User::findOrFail($studentId);

        // return $userData;

        $studentData = DB::table('students')
            ->where('user_id', $studentId)
            ->first();

        $students = DB::table('register_courses as scs')
            ->join('students as s', 'scs.student_id', '=', 's.id')
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->join('grades as c', 'scs.course_id', '=', 'c.id')
            ->join('subjects as sub', 'scs.subjects_id', '=', 'sub.id')
            ->select(
                's.id as student_id',
                'u.name as student_name',
                'c.course_name',
                'sub.subject_name',
                'sub.credit_hours',
                'scs.level',
                'scs.semester'
            )
            ->where('s.user_id', Auth::id())
            ->orderBy('s.id')
            ->get();

        // return $students;


        return view('backend.students.showregisteredcourses',compact('students','studentData','userData'));
    }

    public function getChangeStudentsStatusForm($id) {
        $student = Student::findOrFail($id);

        return view('backend.students.changestatus',compact('id','student'));
    }

    // public function changeStudentsStatus(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'student_defer' => 'required|string|in:defer,withdrawn,expelled,Completed'
    //     ]);

    //     try {

    //         $student = Student::findOrFail($id);

    //         if ($validatedData['student_defer'] === 'defer') {
    //             $student = Student::findOrFail($id);

    //             $user = User::findOrFail($student->user_id);

    //             Defer::create($student->toArray());

    //             $user->student()->delete();

    //             return redirect()->back()->with('success', 'Student moved to defer list successfully');
    //         } 
            
    //         if (($validatedData['student_defer'] === 'Completed')) {
    //             $student->status = 'Completed';
    //             $student->save();

    //             return redirect()->back()->with('success', 'Student status updated to Completed successfully');

    //         } 
            
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return redirect()->back()->with('error', 'Student not found.');
    //     } catch (Exception $e) {
    //         Log::error('Error changing student status: ' . $e->getMessage());

    //         return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
    //     }
    // }

    public function changeStudentsStatus(Request $request, $id)
    {   
        $validatedData = $request->validate([
            'student_defer' => 'required|string|in:defer,withdrawn,expelled,Completed,active'
        ]);

        try {
            $student = Student::findOrFail($id);
            $user = User::findOrFail($student->user_id);

            switch ($validatedData['student_defer']) {
                case 'defer':
                    // Create a defer record safely
                    Defer::create($student->toArray());

                    // Soft delete the student (not hard delete!)
                    $student->delete();

                    return redirect()->back()->with('success', 'Student moved to defer list successfully');

                case 'Completed':
                    $student->status = 'Completed';
                    $student->save();
                    return redirect()->back()->with('success', 'Student status updated to Completed successfully');
                case 'active':
                    $student->status = 'active';
                    $student->save();
                    return redirect()->back()->with('success', 'Student status updated to active successfully');

                case 'withdrawn':
                    $student->status = 'Withdrawn';
                    $student->save();
                    return redirect()->back()->with('success', 'Student marked as Withdrawn successfully');

                case 'expelled':
                    $student->status = 'Expelled';
                    $student->save();
                    return redirect()->back()->with('success', 'Student marked as Expelled successfully');
            }
        } catch (\Exception $e) {
            Log::error('Error changing student status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    public function getDeferListForm() {
        $courses = Grade::all();

        $diplomas = Diploma::all();

        return view('backend.students.getdeferlist',compact('courses','diplomas'));
    }

    public function getDeferList(Request $request) {
        try {
            $validatedData = $request->validate([
                'student_category' => 'nullable|in:Academic,Professional',
                'courseID_academic' => 'nullable|string',
                'courseID_professional' => 'nullable|string',
                'level' => 'nullable|in:100,200,300,400',
                'branch' => 'nullable|in:Kasoa,Spintex,Kanda'
            ]);

            $query = DB::table('students_defer_list')
                ->join('users', 'students_defer_list.user_id', '=', 'users.id')
                ->leftJoin('grades', 'students_defer_list.course_id', '=', 'grades.id')
                ->leftJoin('diploma', 'students_defer_list.course_id_prof', '=', 'diploma.id')
                ->select(
                    'students_defer_list.*',
                    'users.name as user_name',
                    'grades.course_name as grade_name',         
                    'diploma.name as diploma_title'     
                );

            if (!empty($validatedData['student_category'])) {
                $query->where('student_category', $validatedData['student_category']);
            }

            if (!empty($validatedData['courseID_academic'])) {
                $query->where('course_id', $validatedData['courseID_academic']);
            }
    
            if (!empty($validatedData['courseID_professional'])) {
                $query->where('course_id_prof', $validatedData['courseID_professional']);
            }
    
            if (!empty($validatedData['level'])) {
                $query->where('level', $validatedData['level']);
            }

            if (!empty($validatedData['branch'])) {
                $query->where('branch', $validatedData['branch']);
            }


            $students = $query->get();

            // return $students;

            return view('backend.students.deferlisttable',compact('students','validatedData'));
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error changing student status: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function getDefaultersReportForm() {
        $courses = Grade::all();
        $diplomas = Diploma::all();

        return view('backend.students.getdefaultersreportform',compact('courses','diplomas'));
    }

    public function restoreDeferStudents($id) {
        try {
            DB::transaction(function () use ($id) {
                $deferStudent = Defer::findOrFail($id);

                // dd($deferStudent);

                $user = User::findOrFail($deferStudent->user_id);

                // dd($user);

                if($user) {
                    $data = $deferStudent->toArray();
                    // dd($data);
                    if($data['branch'] === null) {
                        $data['branch'] = 'Kanda';
                    }

                    // dd($data);
                    unset($data['id'], $data['created_at'], $data['updated_at']);
                    $user->student()->create($data);
                    $deferStudent->delete();
                }
            });

            return redirect()->back()->with('success', 'Student moved out of defer list successfully.');

        } catch (Exception $e) {
            Log::error('Error changing student status: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function getDefaulterList(Request $request) {
        try {
            // dd($request->all( ));
            $validatedData = $request->validate([
                'student_category' => 'nullable|in:Academic,Professional',
                'courseID_academic' => 'nullable',
                'courseID_professional' => 'nullable',
                'level' => 'nullable|in:100,200,300,400'
            ]);

            $studentCategory = $validatedData['student_category'];
            $academicCategory = $validatedData['courseID_academic'];
            $profCategory = $validatedData['courseID_professional'];
            $level = $validatedData['level'];

            $query = Student::with(relations:[ 'user','course','diploma'])->where('balance','>',0);

            if (!empty($studentCategory)) {
                $query->where('student_category', $validatedData['student_category']);
            }

            if (!empty($academicCategory)) {
                $query->where('course_id', $academicCategory);
            }

            if (!empty($profCategory)) {
                $query->where('course_id_prof', $profCategory);
            }

            if (!empty($level)) {
                $query->where('level', $level);
            }

            $defaulterStudents = $query->get();

            // return $defaulterStudents;

            return view('backend.reports.defaultersreport',compact('defaulterStudents','studentCategory','academicCategory','profCategory','level'));
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }

    }

    public function retrieveSoftDeletedStudents() {
        $students = Student::onlyTrashed()
            ->with(['user' => function ($query) {
                $query->withTrashed(); 
            }, 'course', 'diploma']) 
            ->get();

        // return $students;

        return view('backend.students.deletedstudentstable',compact('students'));
    }

    public function restoreDeletedStudent($id)
    {
        try {
            //code...
            $student = Student::withTrashed()->with('user')->findOrFail($id);

            // return $student;
            $student->restore();
            // $student->assignRole('Student');

            if ($student->user && $student->user->trashed()) {
                $student->user->restore();
            }

            return redirect()->back()->with('success', 'Student restored successfully.');
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function matureStudentsIndex(Request $request) {
        $query = MatureStudent::with('course');

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('mature_index_number', 'like', '%' . $request->search . '%');
              });
           }

        $students = $query->orderBy('name', 'asc')->paginate(10);

        return view('backend.students.maturestudentindex',compact('students'));
    }

    public function createMatureStudentForm() {
        $grades = Grade::all();
        
        return view('backend.students.creatematurestudentsform',compact('grades'));
    }

    public function storeMatureStudent(Request $request) {
        try {
            //code...
            // dd($request->all());
            $matureStudentCount = MatureStudent::count();
            $formattedCount = sprintf('%03d', $matureStudentCount + 1);
            $matureIndexNumber = 'MAT'.'-'.Carbon::now()->format('y') . '-'  .Carbon::now()->format('m') .'-'.$formattedCount;
    
            $validatedData = $request->validate([
                'name' => 'required|string',
                'date_of_birth' => 'required|date',
                'amount_paid' => 'required',
                'course_id' => 'required|exists:grades,id',
                'phone' => 'required|string',
                'gender' => 'required|in:Male,Female',
                'currency' => 'required'
            ]);

            MatureStudent::create([
                'name' => $validatedData['name'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'amount_paid' => $validatedData['amount_paid'],
                'course_id' => $validatedData['course_id'],
                'phone' => $validatedData['phone'],
                'gender' => $validatedData['gender'],
                'currency' => $validatedData['currency'],
                'mature_index_number' => $matureIndexNumber
            ]);

            return view('backend.students.maturestudentreceipt',compact('validatedData','matureIndexNumber'));

            // return redirect()->back()->with('success', 'Mature student saved successfully');
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function deleteMatureStudent($id) {
        try {
            //code...
            $matureStudent = MatureStudent::findOrFail($id);

            $matureStudent->delete();

            return redirect()->back()->with('success', 'Mature student deleted successfully');
        } catch (Exception $e) {
            //throw $th;
              //throw $th;
              Log::error('Error: ' . $e->getMessage());

              return redirect()->back()->with(key:'error',value:'Error deleting student');
        }
    }

    public function editMatureStudentForm($id) {
        $matureStudent = MatureStudent::findOrFail($id);

        $courses = Grade::all();

        return view('backend.students.maturestudenteditform',compact('matureStudent','courses'));
    }

    public function editMatureStudent(Request $request, $id) {
        try {
            //code...
            // dd($request->all());
            $validatedData = $request->validate([
                'name' => 'required|string',
                'date_of_birth' => 'required|date',
                'amount_paid' => 'required',
                'course_id' => 'required|exists:grades,id',
                'phone' => 'required|string',
                'gender' => 'required|in:Male,Female',
                'currency' => 'required'
            ]);
    
            $matureStudent = MatureStudent::findOrFail($id);
    
            $matureStudent->update($validatedData);
    
            return redirect()->back()->with(key:'success',value:'Mature student updated successfully');
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->with(key:'key',value:'An unexpected error occurred. Please try again.');
        }
    }

    public function moveMatureStudentToStudentForm($id) {
        $courses = Grade::latest()->get();
        $parents = Parents::with('user')->latest()->get();
        $diplomas = Diploma::all();
        $years = AcademicYear::all();
        $matureStudent = MatureStudent::findOrFail($id);

        return view('backend.students.movematuretostudentform',compact('courses','parents','diplomas','years','matureStudent'));
    }

    public function moveMatureStudentToStudent(Request $request, $id) {
        try {
            //code...
            // dd($request->all());
            $rules = [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'phone' => 'required|string|max:20',
                'gender' => 'required|in:male,female,other',
                'attendance_time' => 'required|in:weekday,weekend',
                'dateofbirth' => 'required|date',
                'current_address' => 'required|string',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'student_parent' => 'required|string|max:255',
                'parent_phonenumber' => 'required|string|max:20',
                'student_category' => 'required|in:Professional,Academic',
                'scholarship' => 'required|in:Yes,No',
                'scholarship_amount' => 'nullable|numeric|required_if:scholarship,Yes'
            ];
    
              // Conditional validation based on student category
              if ($request->student_category === 'Professional') {
                $rules['course_id_prof'] = 'required|exists:diploma,id';
                $rules['currency_prof'] = 'required|string';
                $rules['fees_prof'] = 'required|numeric';
                $rules['duration_prof'] = 'required|string';
            } elseif ($request->student_category === 'Academic') {
                $rules['course_id'] = 'required|exists:grades,id';
                $rules['currency'] = 'required|string';
                $rules['fees'] = 'required|numeric';
                $rules['level'] = 'required|in:100,200,300,400';
                $rules['session'] = 'required|in:1,2';
                $rules['academicyear'] = 'required';
            }
    
            $validatedData = $request->validate($rules);
    
            DB::beginTransaction();
    
            $user = User::create([
                        'name'              => $validatedData['name'],
                        'email'             => $validatedData['email'],
                        'password'          => Hash::make($validatedData['password'])
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
    
            if ($request->student_category === 'Professional') {
                $courseID = $validatedData['course_id_prof'];
                $query = Diploma::findOrFail($courseID);
                $studentCount = Student::where('course_id_prof', $query['id'])->count();
                $formattedCount = sprintf('%03d', $studentCount + 1);
                $attend = ($validatedData['attendance_time'] === 'weekday') ? "WD" :"WE";
                $studentIndexNumber = $query['code'] ."/". Carbon::now()->year ."/". Carbon::now()->month . "/" . $attend ."/".$formattedCount; 
                // return $studentIndexNumber;
                $user->student()->create([
                    'phone' => $validatedData['phone'],
                    'gender' => $validatedData['gender'],
                    'attendance_time' => $validatedData['attendance_time'],
                    'dateofbirth' => $validatedData['dateofbirth'],
                    'current_address' => $validatedData['current_address'],
                    'index_number' => $studentIndexNumber,
                    'student_parent' => $validatedData['student_parent'],
                    'parent_phonenumber' => $validatedData['parent_phonenumber'],
                    'student_category' => $validatedData['student_category'],
                    'course_id_prof' => $validatedData['course_id_prof'],
                    'currency_prof' => $validatedData['currency_prof'],
                    'fees_prof' => $validatedData['fees_prof'],
                    'balance' => $validatedData['fees_prof'],
                    'duration_prof' => $validatedData['duration_prof'],
                    'Scholarship' => $validatedData['scholarship'],
                    'Scholarship_amount' => $validatedData['scholarship_amount']
                ]);
            }  elseif ($request->student_category === 'Academic') {
                $courseID = $validatedData['course_id'];
                $query = Grade::findOrFail($courseID);
                $studentCount = Student::where('course_id', $query['id'])->count();
                $formattedCount = sprintf('%03d', $studentCount + 1);
                $attend = ($validatedData['attendance_time'] === 'weekday') ? "WD" :"WE";
                $studentIndexNumber = $query['course_code'] ."/". Carbon::now()->year ."/". Carbon::now()->month . "/" . $attend ."/".$formattedCount; 
                // return $studentIndexNumber;
                $user->student()->create([
                    'phone' => $validatedData['phone'],
                    'gender' => $validatedData['gender'],
                    'attendance_time' => $validatedData['attendance_time'],
                    'dateofbirth' => $validatedData['dateofbirth'],
                    'current_address' => $validatedData['current_address'],
                    'index_number' => $studentIndexNumber,
                    'student_parent' => $validatedData['student_parent'],
                    'parent_phonenumber' => $validatedData['parent_phonenumber'],
                    'student_category' => $validatedData['student_category'],
                    'course_id' => $validatedData['course_id'],
                    'currency' => $validatedData['currency'],
                    'fees' => $validatedData['fees'],
                    'balance' => $validatedData['fees'],
                    'level' => $validatedData['level'],
                    'session' => $validatedData['session'],
                    'academicyear' => $validatedData['academicyear'],
                    'Scholarship' => $validatedData['scholarship'],
                    'Scholarship_amount' => $validatedData['scholarship_amount']
                ]);
            }  
    
            $user->assignRole('Student');
    
            // $matureStudent = MatureStudent::findOrFail($id);
    
            // $matureStudent->delete();
    
            DB::commit();

            $matureStudent = MatureStudent::findOrFail($id);
    
            $matureStudent->delete();

            return redirect()->back()->with('success', 'Student created successfully');    
        } catch (ValidationException $e) {
            DB::rollBack();

            // Log::info('Request Data:', $request->all());

            // Log::error('Error creating student: ' . $e);

            // return redirect()->back()->withErrors(Validator::class)->withInput();

            Log::error('Validation Failed', [
                'errors' => $e->validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            
            return redirect()->back()->withErrors($e->errors())->withInput();


            // Return error response
            // return back()->withInput()->withErrors(['error' => 'An error occurred while creating the student. Please try again.']);
        }
    }

    public function deleteEnquiry($id) {
        try {
            //code...
            $enquiry = Enquiry::findOrFail($id);

            $enquiry->delete();

            return redirect()->back()->with(key:'success',value:'Enquiry deleted successfully');
        } catch (\Throwable $th) {

            return redirect()->back()->with(key:'error',value:'Enquiry deleted unsuccessful');
        }
    }

    public function printEnquiryReceipt($id) {
        $enquiry = Enquiry::findOrFail($id);

        return view('backend.fees.enquiryreceipt', compact('enquiry'));
    }

    public function buyFormsLater($id) {
        $enquiry = Enquiry::with(['course','diploma'])->findOrFail($id);

        $courses = null;

        if($enquiry->type_of_course === 'Academic') {
            $courses = Grade::all();
        } elseif($enquiry->type_of_course === 'Professional') {
            $courses = Diploma::all();
        }

        // return $enquiry;

        return view('backend.students.buyforms',compact('enquiry','courses'));   
    }

    public function createUsersForm() {
        $roles = DB::select('Select * from roles');
        return view('backend.settings.createuserform', compact('roles'));
    }

    public function createUser(Request $request) {
        try {
            // dd($request->all());
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string|min:8',
                'role' => 'required'
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password'])
            ]);

            $user->assignRole($validatedData['role']);   

            return redirect()->back()->with('success', 'User created and role ');
        } catch (Exception $e) {
            //throw $th;
             Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function matureStudentReceipt($id) {
        try {
            //code...
             $matureStudent = MatureStudent::findorFail($id);

             return view('backend.fees.maturestudentreceipt', compact('matureStudent'));
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->back()->with('error','Error generating receipt');
        }
       
    }

    public function lecturerEvaluationForm() {
        $userId = Auth::user()->id;
        $student = DB::table('students')
                ->where('user_id', $userId)
                ->first();

        if($student->student_category === 'Academic') {
            $course = Grade::findOrFail($student->course_id);

            $courses = DB::table('register_courses as rc')
                ->join('students as st', 'st.id', '=', 'rc.student_id')
                ->join('grades as c', 'c.id', '=', 'rc.course_id')   
                ->join('subjects as sub', 'sub.id', '=', 'rc.subjects_id')
                ->where('st.id', $student->id)
                ->select(
                    'c.course_name as course_name',
                    'sub.subject_name as subject_name',
                    'sub.subject_code',
                    'rc.level',
                    'rc.semester',
                    'sub.credit_hours'
                )
                ->orderBy('rc.level')
                ->orderBy('rc.semester')
                ->orderBy('c.course_name')
                ->orderBy('sub.subject_name')
                ->get();

            $courseName = $courses[0]->course_name; 

           return view('backend.students.lecturerevaluationform',compact('courseName','student','courses'));
        } 
    }

    public function evaluateLecturer(Request $request) {
        $validated = $request->validate([
            'course' => 'required|string',
            'evaluations.*.subject_name' => 'required|string|max:255',
            'evaluations.*.lecturer'     => 'required|string|max:255',
            'evaluations.*.clarity'      => 'required|integer|min:1|max:5',
            'evaluations.*.knowledge'    => 'required|integer|min:1|max:5',
            'evaluations.*.punctuality'  => 'required|integer|min:1|max:5',
            'evaluations.*.comments'     => 'nullable|string|max:1000',
        ]);

        // return $validated;

        $userId = Auth::user()->id;

        $student = DB::table('students')
                ->where('user_id', $userId)
                ->first();

        DB::beginTransaction();

        try {
            $submission = LecturerEvaluationSubmission::create([
                'student_id' => $student->id, 
                'course_name' => $validated['course'],
                'semester' => $student->session,
                'level' => $student->level,
            ]);

              foreach ($validated['evaluations'] as $subjectCode => $evaluation) {
                LecturerEvaluationDetail::create([
                    'submission_id' => $submission->id,
                    'subject_code' => $subjectCode,
                    'subject_name' => $evaluation['subject'] ?? '',
                    'lecturer_name' => $evaluation['lecturer'] ?? '',
                    'clarity' => $evaluation['clarity'],
                    'knowledge' => $evaluation['knowledge'],
                    'punctuality' => $evaluation['punctuality'],
                    'comments' => $evaluation['comments'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Evaluation submitted successfully!');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            Log::error('Error: ' . $th->getMessage());

            return redirect()->back()->with('error', 'Something went wrong: '.$th->getMessage());
        }
    }

    public function studentsReportsForm() {
        $grades = Grade::all();
        $diplomas = Diploma::all();

        return view('backend.reports.students',compact('grades','diplomas'));
    }

    public function generateStudentsReport(Request $request) {
        // dd($request->all());
        $validatedData = $request->validate([
            'acaProf' => 'required|in:Academic,Professional,Total',
            'diploma_id' => 'nullable|exists:diploma,id',
            'course_id' => 'nullable|exists:grades,id',
            'level' => 'nullable|in:100,200,300,400',
            'semester' => 'nullable|in:1,2',
            'nationality' => 'nullable|in:Local,Foreign,Total',
            'branch' => 'nullable|in:Kasoa,Spintex,Kanda',
            'status' => 'nullable|in:active,defered,Completed'
        ]);

        $acaProf = $validatedData['acaProf'];
        $diploma_id = $validatedData['diploma_id']; 
        $course_id = $validatedData['course_id'];
        $level = $validatedData['level'];
        $semester = $validatedData['semester'];
        $nationality = $validatedData['nationality'];
        $branch = $validatedData['branch'];
        $status = $validatedData['status'];

        $query = Student::with(['user','course','diploma']);

        if($acaProf !== 'Total') {
            $query->where('student_category', $acaProf);
        } else {
            $query->whereIn('student_category', ['Academic', 'Professional']);
        }
        if (!empty($diploma_id)) {
            $query->where('course_id_prof', $diploma_id);
        }
        if (!empty($course_id)) {
            $query->where('course_id', $course_id);
        }
        if (!empty($level)) {
            $query->where('level', $level);
        }
        if (!empty($semester)) {
            $query->where('session', $semester);
        }

       if (!empty($nationality)) {
        if ($nationality !== 'Total') {
            $query->where('student_type', $nationality);
        } else {
            $query->whereIn('student_type', ['Local', 'Foreign']);
         }
        }
        if (!empty($branch)) {
            $query->where('branch', $branch);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $students = $query->get();

        // return $students;

        $totalStudents = $students->count();

        return view('backend.reports.studentsacademicreport',compact('students','acaProf','diploma_id','course_id','level','semester','nationality','branch','totalStudents','status'));
    }

    public function getPaymentPlanForm($id) {
        $student = Student::with(['paymentPlans.installments','user','course','diploma'])->findOrFail($id);

        // return $student;
        return view('backend.students.paymentplanform',compact('student'));
    }

    public function savePaymentPlan(Request $request, $id) {
        try {
            //code...
            // dd($request->all());
            $student = Student::with(['paymentPlans.installments','user','course','diploma'])->findOrFail($id);

            $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'total_fees_due' => 'required|numeric|min:0',
            'amount_already_paid' => 'required|numeric|min:0',
            'outstanding_balance' => 'required|numeric|min:0',
            'currency' => 'required|string|in:Ghana Cedi,Dollar',
            'installments.*.installments_num' => 'nullable|integer',
            'installments.*.due_date' => 'nullable|date',
            'installments.*.amount' => 'nullable|numeric|min:0',
            'installments.*.payment_method' => 'nullable|string|max:50',
            'installments.*.notes' => 'nullable|string|max:255',
        ]);

            DB::beginTransaction();

            $paymentPlan = PaymentPlan::create([
                'student_id' => $student->id,
                'total_fees_due' => floatval($validatedData['total_fees_due']),
                'outstanding_balance' => floatval($validatedData['outstanding_balance']),
                'amount_already_paid' => floatval($validatedData['amount_already_paid']),
                'currency' => $validatedData['currency']
            ]);

            foreach ($validatedData['installments'] as $installmentData) {
                Installments::create([
                    'payment_plan_id' => $paymentPlan->id,
                    'due_date' => $installmentData['due_date'],
                    'amount' =>floatval($installmentData['amount']),
                    'currency' => $validatedData['currency'],
                    'notes' => $installmentData['notes'] ?? null,
                    'payment_method' => $installmentData['payment_method'] ?? null,
                    'installments_num' => $installmentData['installments_num'],
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Payment plan created successfully.');

        } catch (Exception $e) {
            //throw $th;
            DB::rollBack();

            Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function updateInstallments(Request $request, $planId)
    {
        // dd($request->all());
        try {
            $plan = PaymentPlan::findOrFail($planId);

            // return $plan;
            
            if ($request->has('installments')) {
                foreach ($request->installments as $installmentData) {
                    $installment = Installments::find($installmentData['id']);

                    // return $installment;
                    
                    if ($installment && $installment->payment_plan_id == $plan->id) {
                        // Update paid status and date
                        if (isset($installmentData['is_paid']) && $installmentData['is_paid']) {
                            $installment->paid_on = $installmentData['paid_on'] ?? now();
                            $installment->is_paid = "Yes";
                        } else {
                            $installment->paid_on = null;
                        }
                        
                        // Update notes if provided
                        if (isset($installmentData['notes'])) {
                            $installment->notes = $installmentData['notes'];
                        }
                        
                        $installment->save();
                    }
                }
                
                // Recalculate total paid amount
                $totalPaid = $plan->installments->whereNotNull('paid_on')->sum('amount');
                $plan->amount_already_paid = $totalPaid;
                $plan->outstanding_balance = $plan->total_fees_due - $totalPaid;
                $plan->save();
            }
            
            return redirect()->back()->with('success', 'Payment status updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating payments: ' . $e->getMessage());
        }
    }
}

