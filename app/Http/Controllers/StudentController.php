<?php

namespace App\Http\Controllers;

use App\Fees;
use App\User;
use App\Grade;
use App\Level;
use App\Diploma;
use App\Enquiry;
use App\Parents;
use App\Session;
use App\Student;
use App\AcademicYear;
use ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;
use Nette\Schema\ValidationException as SchemaValidationException;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $students = Student::with('class')->latest()->paginate(10);

    //     return view('backend.students.index', compact('students'));
    // }

    public function index(Request $request)
    {
        // Fetch students and handle search
        $query = Student::with('user', 'course', 'diploma')
            ->where(function ($q) {
                $q->whereNotNull('course_id')
                ->orWhereNotNull('course_id_prof');
            });

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->orWhere('index_number', 'like', '%' . $request->search . '%');
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
        // $years = AcademicYear::all();
        // $levels = Level::all();
        
        return view('backend.students.create', compact('courses','parents', 'diplomas'));
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
                'phone' => 'required|string|max:15',
                'gender' => 'required|in:male,female,other',
                'attendance_time' => 'required|in:weekday,weekend',
                'dateofbirth' => 'required|date',
                'current_address' => 'required|string',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'student_parent' => 'required|string|max:255',
                'parent_phonenumber' => 'required|string|max:15',
                'student_category' => 'required|in:Professional,Academic',
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
            }

            $validatedData = $request->validate($rules);

            // dd($validatedData);
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
                $user->student()->create([
                    'phone' => $validatedData['phone'],
                    'gender' => $validatedData['gender'],
                    'attendance_time' => $validatedData['attendance_time'],
                    'dateofbirth' => $validatedData['dateofbirth'],
                    'current_address' => $validatedData['current_address'],
                    'index_number' => $request->index_number,
                    'student_parent' => $validatedData['student_parent'],
                    'parent_phonenumber' => $validatedData['parent_phonenumber'],
                    'student_category' => $validatedData['student_category'],
                    'course_id_prof' => $validatedData['course_id_prof'],
                    'currency_prof' => $validatedData['currency_prof'],
                    'fees_prof' => $validatedData['fees_prof'],
                    'duration_prof' => $validatedData['duration_prof']
                ]);
            }  elseif ($request->student_category === 'Academic') {
                $user->student()->create([
                    'phone' => $validatedData['phone'],
                    'gender' => $validatedData['gender'],
                    'attendance_time' => $validatedData['attendance_time'],
                    'dateofbirth' => $validatedData['dateofbirth'],
                    'current_address' => $validatedData['current_address'],
                    'index_number' => $request->index_number,
                    'student_parent' => $validatedData['student_parent'],
                    'parent_phonenumber' => $validatedData['parent_phonenumber'],
                    'student_category' => $validatedData['student_category'],
                    'course_id' => $validatedData['course_id'],
                    'currency' => $validatedData['currency'],
                    'fees' => $validatedData['fees'],
                    'level' => $validatedData['level'],
                    'session' => $validatedData['session'],
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
    public function show(Student $student)
    {
        $class = Grade::with('subjects')->where('id', $student->class_id)->first();
        
        return view('backend.students.show', compact('class','student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $classes = Grade::latest()->get();
        $parents = Parents::with('user')->latest()->get();

        return view('backend.students.edit', compact('classes','parents','student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email,'.$student->user_id,
            'parent_id'         => 'required|numeric',
            'class_id'          => 'required|numeric',
            'roll_number'       => [
                'required',
                'numeric',
                Rule::unique('students')->ignore($student->id)->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id);
                })
            ],
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
            // 'academicyear'      => 'required|numeric',
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($student->user->name).'-'.$student->user->id.'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = $student->user->profile_picture;
        }

        $student->user()->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'profile_picture'   => $profile
        ]);

        $student->update([
            'parent_id'         => $request->parent_id,
            'class_id'          => $request->class_id,
            'roll_number'       => $request->roll_number,
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        return redirect()->route('student.index');
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
        $students = Student::all();

        return $students;
    }

    public function printAdmissionLetter($id) {
        $student = Student::findOrFail($id);

        return view('backend.students.printletter', compact('student'));
    }

    public function studentSchoolFees() {
        $fees = Fees::paginate(10);

        return view('backend.students.schoolfees', compact('fees'));
    }

    public function test2() {
        $students = Student::with(['class','parent'])->get(); // Eager load the 'class' relationship
        return $students;
    }

    public function studentEnquiry() {
        $enquiries = Enquiry::paginate(5);

        return view('backend.students.enquiry', compact('enquiries'));
    }

    public function saveStudentEnquiry() {
        $courses = Grade::all(['course_name']);

        return view('backend.students.enquiryform', compact('courses'));
    }

    public function storeEnquiry(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'telephone_number' => 'required|string',
            'course' => 'required|string',
            'expected_start_date' => 'required'
        ]);

        Enquiry::create([
            'name' => $validatedData['name'],
            'telephone_number' => $validatedData['telephone_number'],
            'interested_course' => $validatedData['course'],
            'expected_start_date' => $validatedData['expected_start_date']
        ]);

        return redirect()->back()->with('success', 'Enquiry created successfully');
    }

    public function test3()
    {
        // $parents = Parents::with(['user','children'])->get();
        // $parents = Parents::with(['user','children'])->latest()->paginate(10);
        // $parents = Parents::with('user')->latest()->get();
        $parents = Grade::all();



        return $parents;
        
        // return view('backend.parents.index', compact('parents'));
    }

    public function migration() {
        $levels = Level::all('name');
        $semesters = Session::all(['name']);

        return view("backend.students.migration", compact('levels', 'semesters'));
    }

    public function promoteAll(Request $request) {

        $validatedData = $request->validate([
            'current_level' => 'required',
            'current_semester' => 'required',
            'target_level ' => 'required',
            'target_semester'=>'required'
        ]);

        $from = $validatedData['from'];
        $to = $validatedData['to'];

        // Find all students currently at level 100
        $students = Student::where('level', $from)->get();

        // dd($students);

        // Check if any students are found
        if ($students->isEmpty()) {
            return redirect()->back()->with('failure', 'No students found');
        }

        // Update the level for all eligible students
        Student::where('level', $from)->update(['level' => $to]);

        // Return a success response
        return redirect()->back()->with('success', 'Students migrated successfully');
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

    return $students;

    return view('backend.students.index', compact('students'));
}

    // public function test22() {
    //     // $results = Student::with('class','user')->get();
    //     $courseId = Student::whereNotNull('course_id')
    //                ->orWhereNotNull('course_id_prof')
    //                ->value('course_id') ?? Student::whereNotNull('course_id_prof')->value('course_id_prof');

    //     if ($courseId) {
    //         $student = Student::where('course_id', $courseId)
    //                         ->orWhere('course_id_prof', $courseId)
    //                         ->first();
            
    //         return response()->json($student);
    //     } else {
    //         return response()->json(['message' => 'No student found'], 404);
    //     }
    // }
}
