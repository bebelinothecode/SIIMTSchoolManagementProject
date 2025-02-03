<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

//This controller is for courses
class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Grade::with('subjects')->get();

        // dd($courses);
        
        return view('backend.subjects.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::latest()->get();

        $courses = Grade::all();

        return view('backend.subjects.create', compact('teachers', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'course_code'          => 'required|string',
            'course_name'  => 'required|string',
            'description'    => 'required|string',
            'currency'   => 'required|string',
            'fees'   => 'required|string',
        ]);

        // dd($validatedData);

        Grade::create([
            'course_code'          => $validatedData['course_code'],
            'course_name'          => $validatedData['course_name'],
            'course_description'   => $validatedData['description'],
            'currency'             => $validatedData['currency'],
            'fees'                 => $validatedData['fees'],
        ]);

        return redirect()->back()->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $teachers = Teacher::latest()->get();

        return view('backend.subjects.edit', compact('subject','teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:subjects,name,'.$subject->id,
            'subject_code'  => 'required|numeric',
            'teacher_id'    => 'required|numeric',
            'description'   => 'required|string|max:255'
        ]);

        $subject->update([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'subject_code'  => $request->subject_code,
            'teacher_id'    => $request->teacher_id,
            'description'   => $request->description
        ]);

        return redirect()->route('subject.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return back();
    }

    public function index4()
    {
        $courses = Grade::with('grades')::all();

        dd($courses);
        
        return view('backend.subjects.index', compact('courses'));
    }
}
