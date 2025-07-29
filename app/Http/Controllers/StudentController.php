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
use App\Session;
use App\Student;
use App\Subject;
use App\FeesType;
use Carbon\Carbon;
use App\AcademicYear;
use App\Defer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\MatureStudent;
use App\RegisterCourse;
use Dotenv\Exception\ValidationException;
use Dotenv\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Schema\ValidationException as SchemaValidationException;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort');

        $query = Student::with('user', 'course', 'diploma')
            ->join('users', 'students.user_id', '=', 'users.id')
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
            //Validate common fields
            $rules = [
                'branch' => 'required|string|in:Kasoa,Spintex,Kanda',
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
                'parent_phonenumber' => 'required|string|max:15',
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
                $branchPrefixes = [
                    'Kasoa' => 'KS',
                    'Kanda' => 'KD',
                    'Spintex' => 'SP',
                ];

                $branchCode = $branchPrefixes[$validatedData['branch']] ?? "XX";
                // return $branchCode;
                $studentIndexNumber = $branchCode ."/". $query['code'] ."/". Carbon::now()->year ."/". Carbon::now()->month . "/" . $attend ."/".$formattedCount; 
               
                // $studentIndexNumber = $query['code'] ."/". Carbon::now()->year ."/". Carbon::now()->month . "/" . $attend ."/".$formattedCount; 
                // return $studentIndexNumber;
                $user->student()->create([
                    'branch' => $validatedData['branch'],
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
                    'branch' => $validatedData['branch'],
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
                    'level' => $validatedData['level'],
                    'session' => $validatedData['session'],
                    'academicyear' => $validatedData['academicyear'],
                    'Scholarship' => $validatedData['scholarship'],
                    'Scholarship_amount' => $validatedData['scholarship_amount']
                ]);
            }  

        $user->assignRole('Student');

        DB::commit();

        return redirect()->back()->with('success', 'Student created successfully');    
        } catch (SchemaValidationException $e) {
            //throw $th;
            DB::rollBack();

            Log::info('Request Data:', $request->all());

            Log::error('Error creating student: ' . $e);

            // Return error response
            return back()->withInput()->withErrors(['error' => 'An error occurred while creating the student. Please try again.']);
        }
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

        return view('backend.students.show', compact('student'));
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
        
        $parents = Parents::with('user')->latest()->get();

        return view('backend.students.edit', compact('courses','parents','student'));
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

    public function printAdmissionLetter($id) {
        // $student = Student::findOrFail($id);

        $student = Student::with('user', 'course', 'diploma')
            ->where(function ($q) {
                $q->whereNotNull('course_id')
                ->orWhereNotNull('course_id_prof');
            })->findOrFail($id);
        
        // return $student;

        $academicyear = AcademicYear::latest()->first();

        return view('backend.students.printletter', compact('student', 'academicyear'));
    }

    public function studentSchoolFees() {
        $fees = Fees::paginate(10);

        return view('backend.students.schoolfees', compact('fees'));
    }

    public function test2() {
        $students = Student::with(['class','parent'])->get(); // Eager load the 'class' relationship
        return $students;
    }

    // public function studentEnquiry(Request $request)
    // {
    //     // Get the sorting parameter from the request
    //     $sort = $request->query('sort');

    //     // Query the enquiries
    //     $enquiries = Enquiry::when($sort, function ($query, $sort) {
    //         // Filter by type_of_course if a sort value is provided
    //         return $query->where('type_of_course', $sort);
    //     })
    //     ->latest() // Sort by the latest entries
    //     ->paginate(5); // Paginate the results

    //     $searchTerm = $request->input('search');

    //     $results = Enquiry::where(function ($query) use ($searchTerm) {
    //         $query->where('name', 'LIKE', "%{$searchTerm}%")
    //             ->orWhere('telephone_number', 'LIKE', "%{$searchTerm}%")
    //             ->orWhere('interested_course', 'LIKE', "%{$searchTerm}%")
    //             ->orWhere('bought_forms', 'LIKE', "%{$searchTerm}%")
    //             ->orWhere('amount', 'LIKE', "%{$searchTerm}%");
    //     })->get();

    //     // Return the view with the enquiries data
    //     return view('backend.students.enquiry', compact('enquiries'));
    // }

    public function studentEnquiry(Request $request)
    {
        try {
            //code...
            $query = Enquiry::query();

            if($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('telephone_number', 'like', "%{$searchTerm}%")
                      ->orWhere('interested_course', 'like', "%{$searchTerm}%")
                      ->orWhere('type_of_course', 'like', "%{$searchTerm}%");
                });
            }

            // Apply sorting filter if sort parameter is present
            if ($request->has('sort') && !empty($request->sort)) {
                $query->where('type_of_course', $request->sort);
            }

            // Order by latest first and paginate
            $enquiries = $query->latest()->paginate(10);

            return view('backend.students.enquiry', compact('enquiries'));
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error searching enquiry:' . $e);
        }
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

        $dropdownItems = $courses->map(function ($course) {
            return ['id' => $course->id, 'name' => $course->course_name];
        })->merge($diplomas->map(function ($diploma) {
            return ['id' => $diploma->id, 'name' => $diploma->name];
        }));

        return view('backend.students.enquiryform', compact('dropdownItems'));
    }

    public function storeEnquiry(Request $request) {
        try {
            // dd(Auth::user());
            // return Auth::user()->name;
            $receipt_number = "RCPT-".date('Y-m-d')."-".strtoupper(Str::random(8)); 

            
        $validatedData = $request->validate([
            'name' => 'required|string',
            'telephone_number' => 'required|string',
            'course' => 'required|string',
            'expected_start_date' => 'required',
            'type_of_course' => 'required',
            'bought_forms' => 'nullable|in:Yes,No',
            'currency' => 'nullable|string',
            'amount_paid' => 'nullable|numeric',
            'User' => 'nullable|string',
            'receipt_number'=> $receipt_number
        ]);

        // dd($validatedData);

        $enquiry = Enquiry::create([
            'name' => $validatedData['name'],
            'telephone_number' => $validatedData['telephone_number'],
            'interested_course' => $validatedData['course'],
            'expected_start_date' => $validatedData['expected_start_date'],
            'type_of_course' => $validatedData['type_of_course'],
            'bought_forms' => $validatedData['bought_forms'],
            'currency' => $validatedData['currency'],
            'amount' => $validatedData['amount_paid'],
            'User' => Auth::user()->name
        ]);

        if($validatedData['bought_forms'] === 'Yes') {
            return view('backend.fees.enquiryreceipt',compact('enquiry','receipt_number'));
            // return response()->json([
            //     'status' => 'success',
            //     'redirect_url' => route('enquiry.receipt', ['id' => $enquiry->id]),
            //     'message' => 'Enquiry saved and receipt generated.'
            // ]);
        }

        return redirect()->back()->with('success', 'Enquiry created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            //throw $th;
            Log::error('Validation errors: ', $e->errors());

            return redirect()->back()->with('error', 'Error saving Enquiry');
        } 
        // dd($request->all());

    }

    public function migration() {
        $levels = Level::all('name');
        $semesters = Session::all(['name']);

        return view("backend.students.migration", compact('levels', 'semesters'));
    }
   
    public function updateStudent(Request $request, $id) {
        try {
            //code...
            // dd($request->all());
            $validatedData = $request->validate([
                            'name' => 'required|string|max:255',
                            'email' => 'required|email|max:255',
                            'phone' => 'required|string|max:20',
                            'gender' => 'required|in:male,female,other',
                            'dateofbirth' => 'required|date',
                            'current_address' => 'required|string',
                            'fees' => 'required|numeric|min:0',
                            'currency' => 'required|string|max:15',
                            'balance' => 'required|numeric',
                            'course_id' => 'required|integer',
                            'parent_id' => 'required|exists:parents,id'
                        ]);
            $student = Student::findOrFail($id);

            // if ($request->hasFile('profile_picture')) {
            //     $profile = Str::slug($student->user->name).'-'.$student->user->id.'.'.$request->profile_picture->getClientOriginalExtension();
            //     $request->profile_picture->move(public_path('images/profile'), $profile);
            // } else {
            //     $profile = $student->user->profile_picture;
            // }
            $profilePicture = $student->user->profile_picture;
            if ($request->hasFile('profile_picture')) {
                $extension = $request->file('profile_picture')->getClientOriginalExtension();
                $profilePicture = Str::slug($student->user->name) . '-' . $student->user->id . '.' . $extension;
                $request->file('profile_picture')->move(public_path('images/profile'), $profilePicture);
            }

            // $userFieldsToUpdate = [
            //     'name' => $validatedData['name'],
            //     'email' => $validatedData['email']
            // ];

            // $student->user()->update($userFieldsToUpdate);
            $student->user()->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'profile_picture' => $profilePicture
            ]);

            $studentFields = [
                'phone' => $validatedData['phone'],
                'gender' => $validatedData['gender'],
                'dateofbirth' => $validatedData['dateofbirth'],
                'current_address' => $validatedData['current_address'],
                'balance' => $validatedData['balance']
            ];

            if ($student->student_category === 'Academic') {
                $studentFields['fees'] = $validatedData['fees'];
                $studentFields['course_id'] = $validatedData['course_id'];
            } elseif ($student->student_category === 'Professional') {
                $studentFields['fees_prof'] = $validatedData['fees'];
                $studentFields['course_id_prof'] = $validatedData['course_id'];
            }

            $student->update($studentFields);

            return redirect()->back()->with('success', 'Student updated successfully');        
        } catch (Exception $e) {
            Log::error(message: "Error occured updating student" .$e);

            return redirect()->back()->with('error', 'Error updating Student');
        }
    }
    
    public function payStudentFeesForm($id) {
        $student = Student::with('user')->findOrFail($id);
        $studentName = $student->user->name;
        $studentIndexNumber = $student->index_number;
        $student_balance = $student->balance;
        $feesTypes = FeesType::all();
        // return $student;
        return view('backend.students.payfeesform', compact('student','studentName','studentIndexNumber','student_balance','feesTypes'));
    }

    public function promoteAll(Request $request) {
        try {
            // dd($request->all());

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

            // Find all students currently at level 100
            $students = Student::with('user')->where('level', $fromLevel)
                                    ->where('session', $fromSemester)
                                    ->get();

        
            // Check if any students are found
            if ($students->isEmpty()) {
                return redirect()->back()->with('error', 'No students found');
            }

            foreach($students as $student) {
                $student->level = $toLevel;
                $student->session = $toSemester;
                $student->save();
            }

            return redirect()->back()->with('success', 'Students migrated successfully');
        } catch (Exception $e) {
            //throw $th;
            Log::error('An error occurred', [
                'exception' => $e, // Include the exception in the context array
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
                    'level_id' => $level_id,
                    'semester_id' => $semester_id
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

    public function getCourseOutlineForm()
    {
        try {
            // Get authenticated user
            $userId = Auth::id();
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            // Get student record
            $student = DB::table('students')
                ->where('user_id', $userId)
                ->first();

            if (!$student) {
                throw new Exception('Student record not found');
            }

            // Determine course ID (handling both regular and professor cases)
            $courseId = $student->course_id ?? $student->course_id_prof;
            if (!$courseId) {
                throw new Exception('No course assigned to student');
            }

            // Get course with subjects grouped by level and semester
            $course = Grade::with(['assignSubjectsToCourse' => function ($query) {
                $query->withPivot('level_id', 'semester_id')
                    ->orderBy('pivot_level_id')
                    ->orderBy('pivot_semester_id');
            }])->findOrFail($courseId);

            // Group subjects by level and semester
            $subjects = $course->assignSubjectsToCourse->groupBy(function ($subject) {
                return 'Level ' . $subject->pivot->level_id . ' - Semester ' . $subject->pivot->semester_id;
            });

            // return $subjects;

            return view('backend.students.getcourseoutline', compact('subjects','student'));

        } catch (Exception $e) {
            Log::error('Error in getCourseOutlineForm: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Failed to load course outline: ' . $e->getMessage());
        }
    }

    public function getRegistrationForm() {
        $studentId = Auth::user()->id;

        $student = DB::table('students')
                ->where('user_id', $studentId)
                ->first();

        $course = Grade::findOrFail($student->course_id);

        if($student->level == '100' && $student->session == '1') {
            $subjects = Subject::where('level','100')
            ->where('semester','2')
            ->get();
        } elseif($student->level == '100' && $student->session == '200') {
            $subjects = Subject::where('level','200')
            ->where('semester','1')
            ->get();
        } elseif($student->level == '200' && $student->session == '1') {
            $subjects = Subject::where('level','200')
            ->where('semester','2')
            ->get();
        } elseif($student->level == '200' && $student->session == '2') {
            $subjects = Subject::where('level','300')
            ->where('semester','1')
            ->get();
        }

        $subjects = Subject::where('level',$student->level)
                            ->where('semester',$student->session)
                            ->get();

        // return $student;

        return view('backend.students.registercourse',compact('course','subjects','student','studentId'));
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
        return view('backend.students.showregisteredcourses');
    }

    public function getChangeStudentsStatusForm($id) {
        return view('backend.students.changestatus',compact('id'));
    }

    public function changeStudentsStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'student_defer' => 'required|string|in:defer,withdrawn,expelled'
        ]);

        try {
            if ($validatedData['student_defer'] === 'defer') {
                DB::transaction(function () use ($id) {
                    $student = Student::findOrFail($id);

                    // Defer::create($student->toArray());
                   Defer::create($student->toArray());
                    
                    $student->delete();
                });

                return redirect()->back()->with('success', 'Student moved to defer list successfully');
            } else {
                return redirect()->back()->with('error', 'Only defer action is implemented at the moment.');
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Student not found.');
        } catch (Exception $e) {
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

    // public function restoreDeletedStudent($id) {

    // }

    public function restoreDeletedStudent($id)
    {
        $student = Student::withTrashed()->with('user')->findOrFail($id);

        // return $student;
        $student->restore();
        // $student->assignRole('Student');

        if ($student->user && $student->user->trashed()) {
            $student->user->restore();
        }

        return response()->json([
            'message' => 'Student and related user restored successfully.',
            'student' => $student
        ]);
    }

    public function matureStudentsIndex(Request $request) {
        $query = MatureStudent::with('course');

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('mature_index_number', 'like', '%' . $request->search . '%');
              });
           }

        $students = $query->orderBy('name', 'asc')
        ->paginate(10);

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
                'parent_phonenumber' => 'required|string|max:15',
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
}
