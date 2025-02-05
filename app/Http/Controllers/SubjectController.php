<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $courses = Grade::with('subjects')->latest()->paginate(5);
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
    public function edit($id)
    {
        $courses = Grade::findOrFail($id);

        return view('backend.subjects.edit', compact('courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'course_code' => 'required',
                'course_name' => 'required',
                'description' => 'required',
                'currency' => 'required',
                'fees' => 'required'
            ]);

            $course = Grade::findOrFail($id);

            $course->update([
                'course_code' => $validatedData['course_code'],
                'course_name' => $validatedData['course_name'],
                'description' => $validatedData['description'],
                'currency' => $validatedData['currency'],
                'fees' => $validatedData['fees']
            ]);

            return redirect()->back()->with('success', 'Details updated successfully');
        } catch (\Exception $e) {
            //throw $th;
            Log::error('Error occured', [
                'message' => $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            //code...
            $course = Grade::findOrFail($id);

            $course->delete();
    
            return redirect()->back()->with('success', 'Course deleted successfully');
        } catch (\Exception $e) {
            //throw $th;

            Log::error('Error occured', [
                'message' => $e
            ]);

            return redirect()->back()->with('error', 'Problem deleting course');
        }
       
    }

    public function index4()
    {
        $courses = Grade::with('grades')::all();

        dd($courses);
        
        return view('backend.subjects.index', compact('courses'));
    }
}
