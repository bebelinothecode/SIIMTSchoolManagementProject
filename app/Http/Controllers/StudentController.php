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
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Schema\ValidationException as SchemaValidationException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort');

        // Fetch students and handle search
        $query = Student::with('user', 'course', 'diploma')
        ->where(function ($q) {
            $q->whereNotNull('course_id')
            ->orWhereNotNull('course_id_prof');
        });

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
                })
                ->orWhere('index_number', 'like', '%' . $request->search . '%')
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

        $students = $query->latest()->paginate(10); // Adjust pagination size as needed

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
            //Validate common fields
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Student $student)
    // {
    //     $request->validate([
    //         'name'              => 'required|string|max:255',
    //         'email'             => 'required|string|email|max:255|unique:users,email,'.$student->user_id,
    //         'parent_id'         => 'required|numeric',
    //         'class_id'          => 'required|numeric',
    //         'roll_number'       => [
    //             'required',
    //             'numeric',
    //             Rule::unique('students')->ignore($student->id)->where(function ($query) use ($request) {
    //                 return $query->where('class_id', $request->class_id);
    //             })
    //         ],
    //         'gender'            => 'required|string',
    //         'phone'             => 'required|string|max:255',
    //         'dateofbirth'       => 'required|date',
    //         'current_address'   => 'required|string|max:255',
    //         'permanent_address' => 'required|string|max:255'
    //         // 'academicyear'      => 'required|numeric',
    //     ]);

    //     if ($request->hasFile('profile_picture')) {
    //         $profile = Str::slug($student->user->name).'-'.$student->user->id.'.'.$request->profile_picture->getClientOriginalExtension();
    //         $request->profile_picture->move(public_path('images/profile'), $profile);
    //     } else {
    //         $profile = $student->user->profile_picture;
    //     }

    //     $student->user()->update([
    //         'name'              => $request->name,
    //         'email'             => $request->email,
    //         'profile_picture'   => $profile
    //     ]);

    //     $student->update([
    //         'parent_id'         => $request->parent_id,
    //         'class_id'          => $request->class_id,
    //         'roll_number'       => $request->roll_number,
    //         'gender'            => $request->gender,
    //         'phone'             => $request->phone,
    //         'dateofbirth'       => $request->dateofbirth,
    //         'current_address'   => $request->current_address,
    //         'permanent_address' => $request->permanent_address
    //     ]);

    //     return redirect()->route('student.index');
    // }

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
        $validatedData = $request->validate([
            'name' => 'required|string',
            'telephone_number' => 'required|string',
            'course' => 'required|string',
            'expected_start_date' => 'required',
            'type_of_course' => 'required',
            'bought_forms' => 'nullable|in:Yes,No',
            'currency' => 'nullable|string',
            'amount_paid' => 'nullable|numeric',
            'User' => 'nullable|string'
        ]);

        // dd($validatedData);

        Enquiry::create([
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
            // dd($request->all());
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required',
                'gender' => 'required',
                'dateofbirth' => 'required|date',
                'current_address' => 'required',
                'fees' => 'required',
                'currency' => 'required',
                'balance' => 'required',
                'course_id' => 'required',
                'parent_id' => 'required' 
            ]);

            $student = Student::findOrFail($id);

            $course = Grade::where('id', $validatedData['course_id'])->first();
            $diploma = Diploma::where('id', $validatedData['course_id'])->first();

            $item = $course ?? $diploma;

            if ($request->hasFile('profile_picture')) {
                $profile = Str::slug($student->user->name).'-'.$student->user->id.'.'.$request->profile_picture->getClientOriginalExtension();
                $request->profile_picture->move(public_path('images/profile'), $profile);
            } else {
                $profile = $student->user->profile_picture;
            }

            DB::beginTransaction();

            $student->user()->update([
                'name'              => $validatedData['name'],
                'email'             => $validatedData['email'],
                'profile_picture'   => $profile
            ]);

            $courseChanged = false;

            if($student->student_category === 'Academic') {
                if ($student->course_id != $validatedData['course_id']) {
                    $courseChanged = true;
                }
                $student->update([
                    'course_id' => $validatedData['course_id'],
                    'balance'   => $courseChanged ? '0.0' : $validatedData['balance'],
                    'fees' => $validatedData['fees'],
                    'currency' => $validatedData['currency']
                ]);
            } else {
                if ($student->course_id_prof != $validatedData['course_id']) {
                    $courseChanged = true;
                }
                $student->update([
                    'course_id_prof' => $validatedData['course_id'],
                    'fees' => $validatedData['fees'],
                    'currency_prof' => $validatedData['currency'],
                    'balance' => $courseChanged ? '0.0' : $validatedData['balance']
                ]);
            }

            $student->update([
                'student_parent'    => $validatedData['parent_id'],
                'gender'            => $validatedData['gender'],
                'phone'             => $validatedData['phone'],
                'dateofbirth'       => $validatedData['dateofbirth'],
                'current_address'   => $validatedData['current_address'],
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Student updated successfully');    
        } catch (Exception $e) {
            //throw $th;
            DB::rollBack();

            Log::error("Error occured updating student" .$e);

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
                return redirect()->back()->with('duplicate', 'Cant migrate to the same semester or level');
            }

            // Find all students currently at level 100
            $students = Student::where('level', $fromLevel)
                                    ->where('session', $fromSemester)
                                    ->get();

            // return $students;

        
            // Check if any students are found
            if ($students->isEmpty()) {
                return redirect()->back()->with('error', 'No students found');
            }

            foreach($students as $student) {
                $student->level = $toLevel;
                $student->session = $toSemester;
                $student->save();

                return redirect()->back()->with('success', 'Students migrated successfully');
            }
    
            // Return a error response
            return redirect()->back()->with('error', 'Error saving students details');
        } catch (Exception $e) {
            //throw $th;
            Log::error('An error occurred', [
                'exception' => $e, // Include the exception in the context array
            ]);        
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

    public function getCourseOutlineForm() {
        $userId = Auth::user()->id;
        // $user = Auth::user();

        // return $user;

        $student = Student::findOrFail($userId);

        $courseId = $student->course_id ?? $student->course_id_prof;
        // $course = Grade::findOrFail($courseId) ?? Diploma::findOrFail($courseId);

        // $levels = [100, 200, 300, 400];  

        // $semesters = [1, 2];

        $course = Grade::with(['assignSubjectsToCourse' => function ($query) {
            $query->withPivot('level_id', 'semester_id');
        }])->findOrFail($courseId);

        $groupedSubjects = $course->assignSubjectsToCourse->groupBy(function ($subject) {
            return 'Level ' . $subject->pivot->level_id . ' - Semester ' . $subject->pivot->semester_id;
        });

        return view('backend.students.getcourseoutline',compact('groupedSubjects'));
    }
}
