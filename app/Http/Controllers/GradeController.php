<?php

namespace App\Http\Controllers;

// use Log;
use App\Grade;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{   
    //This controller is for subjects
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Subject::with('course');

            if ($request->filled('search')) {
                $searchTerm = trim($request->input('search'));
                
                $query->where(function($q) use ($searchTerm) {
                    // Search in Subject model fields
                    $q->where('subject_name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('subject_code', 'like', '%' . $searchTerm . '%')
                      ->orWhere('semester', 'like', '%' . $searchTerm . '%')
                      ->orWhere('level', 'like', '%' . $searchTerm . '%')
                      ->orWhere('credit_hours', 'like', '%' . $searchTerm . '%');

                    // Search in related Course model with correct relationship
                    // $q->orWhereHas('course', function($courseQuery) use ($searchTerm) {
                    //     $courseQuery->where('name', 'like', '%' . $searchTerm . '%')
                    //               ->orWhere('code', 'like', '%' . $searchTerm . '%');
                    // });

                    // If search term is numeric, also search by ID
                    if (is_numeric($searchTerm)) {
                        $q->orWhere('id', $searchTerm);
                    }
                });
            }

            $classes = $query->latest()->paginate(10);

            return view('backend.classes.index', [
                'classes' => $classes,
                'search' => $request->input('search')
            ]);
        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage(), [
                'search_term' => $request->input('search'),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withError('An error occurred while processing your search.')
                ->withInput();
        }
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::with('user')->get();

        $courses = Grade::all();
        
        return view('backend.classes.create', compact('teachers', 'courses'));
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

        $validatedData = $request->validate([
            'subject_name'     => 'required',
            'subject_code'     => 'required',
            // 'course_id'        => 'required',
            'level'            => 'required',
            'semester'         => 'required',
            'credit_hours'     => 'required',
        ]);

        Subject::create([
            'subject_name'  => $validatedData['subject_name'],
            'subject_code'  => $validatedData['subject_code'],
            // 'course_id'     => $validatedData['course_id'],
            'level'         => $validatedData['level'],
            'semester'      => $validatedData['semester'],
            'credit_hours'  => $validatedData['credit_hours'],
        ]);

        return redirect()->back()->with('success', 'Subject created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = Subject::findOrFail($id);

        $teachers = Teacher::with('user')->get();

        $courses = Grade::all();

        return view('backend.classes.edit', compact('subjects','teachers','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'subject_name'  => 'required',
            'subject_code'  => 'required',
            'course_id'     => 'nullable',
            'level'         => 'required',
            'semester'      => 'required',
            'credit_hours'  => 'required'
        ]);

        // dd($validatedData);

        $class = Subject::findOrFail($id);

        // dd($class);

        $class->update([
            'subject_name'  => $validatedData['subject_name'],
            'subject_code'  => $validatedData['subject_code'],
            'course_id'     => $validatedData['course_id'],
            'level'         => $validatedData['level'],
            'semester'      => $validatedData['semester'],
            'credit_hours'  => $validatedData['credit_hours']
        ]);

        return redirect()->back()->with('success', 'Subject details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        
        $subject->delete();

        return redirect()->back()->with('success', 'Subject deleted successfully!');
    }

    /*
     * Assign Subjects to Grade 
     * 
     * @return \Illuminate\Http\Response
     */
    public function assignSubject($classid)
    {
        $subjects   = Subject::latest()->get();
        $assigned   = Grade::with(['subjects','students'])->findOrFail($classid);

        return view('backend.classes.assign-subject', compact('classid','subjects','assigned'));
    }

    /*
     * Add Assigned Subjects to Grade 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAssignedSubject(Request $request, $id)
    {
        $class = Grade::findOrFail($id);

        $class->subjects()->sync($request->selectedsubjects);

        return redirect()->route('classes.index');
    }

    public function test4() {
        $classes = Subject::with('course')->paginate(10);

        return $classes;
    }

    // public function 
}
